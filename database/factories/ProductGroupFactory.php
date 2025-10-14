<?php

namespace Database\Factories;

use App\Models\ProductGroup;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductGroupFactory extends Factory
{
    protected $model = ProductGroup::class;

    public function definition(): array
    {
        return [
            'name'        => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'category_id' => Category::factory()->child(),
        ];
    }
}
