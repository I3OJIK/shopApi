<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
use Illuminate\Support\Str;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        $products =  Product::all();

        $colors = AttributeValue::whereHas('attribute', fn($q) => $q->where('name', 'color'))->pluck('id');
        
        $storages = AttributeValue::whereHas('attribute', fn($q) => $q->where('name', 'storage'))->pluck('id');

        foreach ($products as $product) {
            // Создаем 2-4 случайных варианта для каждого продукта
            $variantCount = rand(2, 4);

            for ($i=0; $i < $variantCount; $i++) { 
                
                $colorId = $colors->random();
                $storageId = $storages->random();

                $colorName = AttributeValue::find($colorId)->value;
                $storageName = AttributeValue::find($storageId)->value;
                $sku = sprintf(
                    '%s-%s-%s-%s',
                    substr($product->name, 0, 4),
                    substr(Str::transliterate($colorName), 0, 3),
                    $storageName,
                    substr(md5(microtime()), 0, 5)
                );

                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'sku' => $sku,
                    'price' => rand(1000,100000),
                    'stock' => rand(0,5000)
                ]);

                $variant->attributeValues()->attach([$colorId, $storageId]);
            }

        }


    }
}
