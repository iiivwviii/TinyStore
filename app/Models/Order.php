<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public const STATUS_NEW = 'new';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = [
        self::STATUS_NEW,
        self::STATUS_CONFIRMED,
        self::STATUS_CANCELLED,
    ];

    protected $fillable = [
        'user_id',
        'total',
        'status',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

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

    public function isNew(): bool
    {
        return $this->status === self::STATUS_NEW;
    }

    public function isConfirmed(): bool
    {
        return $this->status === self::STATUS_CONFIRMED;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }
}
