<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $seller_ids = User::pluck('id');

        $seller_id = $this->faker->randomElement($seller_ids);

        $user = User::find($seller_id);
        $is_admin = $user->role == 'admin';

        while (!$is_admin) {
            $seller_id = $this->faker->randomElement($seller_ids);
            $user = User::find($seller_id);
            $is_admin = $user->role == 'admin';
        }

        return [
            'name' => fake()->name(),
            'desc' => fake()->text(),
            'price' => fake()->numberBetween(1000, 500000),
            'image' => fake()->imageUrl(),
            'qty' => fake()->numberBetween(0, 1000),
            'seller_id' => $seller_id,
        ];
    }
}
