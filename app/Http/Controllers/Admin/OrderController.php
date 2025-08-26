<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $res = OrderService::indexAdmin();

        return OrderResource::collection($res);
    }

    public function update(UpdateOrderRequest $request, Order $order): OrderResource
    {
        OrderService::updateStatus($order, $request->status);

        return new OrderResource($order->load(['user', 'items.product']));
    }

    public function destroy(Order $order): JsonResponse
    {
        $res = OrderService::destroy($order);

        return response()->json($res);
    }
}
