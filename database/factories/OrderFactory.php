<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'total' => fake()->randomFloat(2, 10, 1000),
            'status' => fake()->randomElement(Order::STATUSES),
        ];
    }
}
