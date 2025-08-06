<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    public function updated(Order $order): void
    {
        if ($order->isDirty('status')) {
            $oldStatus = $order->getOriginal('status');
            $newStatus = $order->status;

            Log::channel('orders')->info("Order status changed", [
                'order_id' => $order->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'user_id' => auth()->id() ?? 'system',
            ]);
        }
    }

    public function created(Order $order): void
    {
        Log::channel('orders')->info("Added new order", [
            'order_id' => $order->id,
            'user_id' => auth()->id() ?? 'system',
        ]);
    }

    public function deleted(Order $order): void
    {
        Log::channel('orders')->info("Order deleted", [
            'order_id' => $order->id,
            'user_id' => auth()->id() ?? 'system',
        ]);
    }
}
