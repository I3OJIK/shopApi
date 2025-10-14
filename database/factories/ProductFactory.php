<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'product_group_id'  => ProductGroup::factory(),
            'name'              => $this->faker->unique()->words(2, true),
            'size'              => $this->faker->unique()->word(),
            'color'             => $this->faker->unique()->word(),
            'variant'           => $this->faker->unique()->word(),
            'image'             => $this->faker->filePath(),
            'price'             => $this->faker->numberBetween(1000, 100000),
            'stock'             => $this->faker->numberBetween(0, 500),
        ];
    }
}
