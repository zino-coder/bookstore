<?php

namespace Database\Factories;

use Faker\Core\Number;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
    public function definition(): array
    {
        $name = fake()->name();
        $price = fake()->numerify('#####');
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'sku' => Str::random(14),
            'stock' => fake()->numerify('####'),
            'price' => $price,
            'sale_price' => $price * fake()->numerify('##') / 100,
            'category_id' => 21,
            'is_active' => 1,
            'is_hot' => 0,
            'is_feature' => 1,
        ];
    }
}
