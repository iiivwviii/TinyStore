<?php

namespace App\Services;

use App\Http\Requests\ProductFilterRequest;
use App\Models\Product;

class ProductService
{
    public static function index(ProductFilterRequest $request): Product
    {
        $products = Product::query()
            ->filterByCategoryId($request->category_id)
            ->filterByProductName($request->name)
            ->sortByName($request->sort)
            ->with('category')
            ->paginate();

        return $products;
    }
}
