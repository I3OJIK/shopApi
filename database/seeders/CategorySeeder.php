<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\ProductVariant;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            ['name' => 'Смартфоны'],
        ]);
        Category::insert([
            ['name' => 'Iphone', 'parent_id' => 1],
            ['name' => 'Ssmsung', 'parent_id' => 1],
        ]);

    }
    
}
