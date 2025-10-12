<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use App\Models\ProductGroup;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $productGroups =  ProductGroup::all();
        $colors = ['white', 'blue', 'black', 'yellow', 'red', 'orange', 'gray','purple'];
        $sizes = ['126GB', '256GB', '512GB', '1TB', '64GB', '2TB'];
        $variants =['nano SIM + esim', 'nano SIM', 'Limited Edition','','',''];

        foreach ($productGroups as $productGroup) {
            $productCount = rand(2,5);

            for ($i=0; $i < $productCount; $i++) { 
                $color = $colors[array_rand($colors)];
                $size = $sizes[array_rand($sizes)];
                $variant = $variants[array_rand($variants)];

                $name = $productGroup->name . " {$size}, {$color}" . ($variant ? ", {$variant}" : "");

                Product::create([
                    'product_group_id' => $productGroup->id,
                    'name' => $name,
                    'size' => $size,
                    'color' => $color,
                    'variant' => $variant,
                    'price' => rand(10000, 100000),
                    'stock' => rand(1, 1000)
                ]);

            }

        }
       
    }
}