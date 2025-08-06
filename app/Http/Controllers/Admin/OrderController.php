<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        $orders = Order::with(['user', 'items.product'])->paginate();

        return OrderResource::collection($orders);
    }

    public function update(UpdateOrderRequest $request, Order $order): OrderResource
    {
        $this->orderService->updateStatus($order, $request->status);

        return new OrderResource($order->load(['user', 'items.product']));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message' => "Order (ID: {$order->id}) deleted"]);
    }
}
