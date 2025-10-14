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
            'name'              => $this->faker->words(2, true),
            'size'              => $this->faker->word(),
            'color'             => $this->faker->word(),
            'variant'           => $this->faker->word(),
            'image'             => $this->faker->filePath(),
            'price'             => $this->faker->numberBetween(1000, 100000),
            'stock'             => $this->faker->numberBetween(0, 500),
        ];
    }
}
