<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductCategory>
 */
class ProductCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $product_ids = Product::pluck('id');
        $category_ids = Category::pluck('id');

        return [
            'product_id' => fake()->randomElement($product_ids),
            'category_id' => fake()->randomElement($category_ids)
        ];
    }
}
