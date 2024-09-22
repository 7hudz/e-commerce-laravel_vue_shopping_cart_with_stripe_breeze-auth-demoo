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
    public function definition(): array
    {
        return [
            'product_name' => $this->faker->word(),
            'product_desc' => $this->faker->paragraph(),
            'product_price' => $this->faker->randomFloat(2, 1, 1000), // random float with 2 decimal places
            'product_image' => $this->faker->imageUrl(640, 400),
        ];
    }
}
