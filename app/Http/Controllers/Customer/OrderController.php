<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
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
        $orders = Order::where('user_id', auth()->id())->with('items.product')->paginate();

        return OrderResource::collection($orders);
    }

    public function store(CreateOrderRequest $request): OrderResource
    {
        $order = $this->orderService->create(auth()->user(), $request->validated());

        return new OrderResource($order->load('items.product'));
    }
}
