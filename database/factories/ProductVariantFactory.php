<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;


class AttributeFactory extends Factory
{

    protected $model = ProductVariant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'sku' => strtoupper($this->faker->lexify('???-#####')),
            'price' => $this->faker->numberBetween(500, 2000),
            'stock' => $this->faker->numberBetween(0, 100),
        ];
    }


}
