<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public function create(User $user, array $data): Order
    {
        return DB::transaction(function () use ($user, $data) {
            $order = new Order([
                'user_id' => $user->id,
                'status' => Order::STATUS_NEW,
                'total' => 0,
            ]);

            $total = 0;
            $items = [];

            foreach ($data['items'] as $itemData) {
                $product = Product::lockForUpdate()->findOrFail($itemData['product_id']);

                if ($product->quantity < $itemData['quantity']) {
                    throw new \Exception("Not enough quantity for product {$product->name}");
                }

                $product->decrement('quantity', $itemData['quantity']);

                $itemTotal = $product->price * $itemData['quantity'];
                $total += $itemTotal;

                $items[] = new OrderItem([
                    'product_id' => $product->id,
                    'quantity' => $itemData['quantity'],
                    'price' => $product->price,
                ]);
            }

            if ($user->balance < $total) {
                throw new \Exception('Insufficient balance');
            }

            $user->decrement('balance', $total);
            $order->total = $total;
            $order->save();
            $order->items()->saveMany($items);

            Log::info("Order {$order->id} created for user {$user->id} with total {$total}");

            return $order;
        });
    }

    public function updateStatus(Order $order, string $status): void
    {
        DB::transaction(function () use ($order, $status) {
            $oldStatus = $order->status;
            $order->status = $status;
            $order->save();

            if ($oldStatus === Order::STATUS_NEW && $status === Order::STATUS_CANCELLED) {
                $this->cancelOrder($order);
            }

            Log::info("Order {$order->id} status changed from {$oldStatus} to {$status}");
        });
    }

    private function cancelOrder(Order $order): void
    {
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            $product->increment('quantity', $item->quantity);
        }

        $order->user->increment('balance', $order->total);
    }
}
