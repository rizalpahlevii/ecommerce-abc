<?php

namespace Database\Factories;

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
        return [
            'name' => $this->faker->name,
            'price' => rand(100000, 300000),
            'description' => $this->faker->sentence,
            'weight' => rand(100, 200),
            'category' => ['Clothes', 'Tshirt', 'Shirt'][rand(0, 2)]
        ];
    }
}
