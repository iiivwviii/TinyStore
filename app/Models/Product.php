<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'quantity',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];


    #[Scope]
    public function filterByCategoryId(Builder $query, ?string $category_id): Builder
    {
        return $query->when($category_id, fn($q) => $q->where('category_id', $category_id));
    }

    #[Scope]
    public function filterByProductName(Builder $query, ?string $name): Builder
    {
        return $query->when($name, fn($q) => $q->where('name', 'like', "%{$name}%"));
    }

    #[Scope]
    public function sortByName(Builder $query, ?string $sort): Builder
    {
        return $query->when($sort === 'name', fn($q) => $q->orderBy('name'));
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
