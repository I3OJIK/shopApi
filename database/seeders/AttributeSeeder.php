<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductVariant;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        Attribute::insert([
            ['name' => 'color'],
            ['name' => 'storage'],
            ['name' => 'ram'],
            ['name' => 'processor'],
        ]);
    }
}
