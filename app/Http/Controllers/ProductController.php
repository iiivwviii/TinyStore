<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFilterRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(ProductFilterRequest $request): AnonymousResourceCollection
    {
        $res = ProductService::index($request);

        return ProductResource::collection($res);
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product->load('category'));
    }
}
