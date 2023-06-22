<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $product_ids = Product::pluck('id');
        $buyer_ids = User::pluck('id');

        $product_id = fake()->randomElement($product_ids);
        $buyer_id = fake()->randomElement($buyer_ids);

        $product = Product::find($product_id);
        $price = $product->price;
        $seller_id = $product->seller_id;

        $qty = fake()->numberBetween(1, 50);
        $total_price = $price * $qty;

        return [
            "product_id" => $product_id,
            "buyer_id" => $buyer_id,
            "seller_id" => $seller_id,
            "total_price" => $total_price,
            "qty" => $qty,
            "status" => fake()->randomElement(["pending", "success", "failed"]),
        ];
    }
}
