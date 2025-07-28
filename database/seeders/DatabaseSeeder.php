<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory(10)->create();

        Category::factory(5)->create()->each(function ($category) {
            Product::factory(10)->create(['category_id' => $category->id]);
        });

        Order::factory(20)->create()->each(function ($order) {
            $products = Product::inRandomOrder()->limit(3)->get();

            foreach ($products as $product) {
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => rand(1, 3),
                    'price' => $product->price,
                ]);
            }

            $total = $order->items->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            $order->update(['total' => $total]);
        });
    }
}
