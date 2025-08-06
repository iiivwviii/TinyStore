<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFilterRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(ProductFilterRequest $request): AnonymousResourceCollection
    {
        $products = Product::query()
            ->filterByCategoryId($request->category_id)
            ->filterByProductName($request->name)
            ->sortByName($request->sort)
            ->with('category')
            ->paginate();

        return ProductResource::collection($products);
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product->load('category'));
    }
}
