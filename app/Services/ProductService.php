<?php

namespace App\Services;

use App\Http\Requests\ProductFilterRequest;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    public static function index(ProductFilterRequest $request): LengthAwarePaginator
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
