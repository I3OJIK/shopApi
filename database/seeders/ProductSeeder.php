<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductVariant;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Создаём атрибуты
        $color = Attribute::create(['name' => 'color', 'is_active' => true]);
        $storage = Attribute::create(['name' => 'storage', 'is_active' => true]);

        // Значения атрибутов
        $red = AttributeValue::create(['attribute_id' => $color->id, 'value' => 'red', 'is_active' => true]);
        $blue = AttributeValue::create(['attribute_id' => $color->id, 'value' => 'blue', 'is_active' => true]);
        $gb128 = AttributeValue::create(['attribute_id' => $storage->id, 'value' => '128GB', 'is_active' => true]);
        $gb256 = AttributeValue::create(['attribute_id' => $storage->id, 'value' => '256GB', 'is_active' => true]);

        // Создаём продукт
        $product = Product::create([
            'name' => 'iPhone 15',
            'description' => 'Новейший iPhone 15 с разными цветами и памятью',
        ]);

        // Создаём варианты
        $variant1 = ProductVariant::create([
            'product_id' => $product->id,
            'sku' => 'IP15-R128',
            'price' => 1000,
            'stock' => 10,
        ]);
        $variant2 = ProductVariant::create([
            'product_id' => $product->id,
            'sku' => 'IP15-R256',
            'price' => 1100,
            'stock' => 5,
        ]);
        $variant3 = ProductVariant::create([
            'product_id' => $product->id,
            'sku' => 'IP15-B128',
            'price' => 1000,
            'stock' => 7,
        ]);
        $variant4 = ProductVariant::create([
            'product_id' => $product->id,
            'sku' => 'IP15-B256',
            'price' => 1100,
            'stock' => 3,
        ]);

        // Привязываем атрибуты к вариантам
        $variant1->attributeValues()->attach([$red->id, $gb128->id]);
        $variant2->attributeValues()->attach([$red->id, $gb256->id]);
        $variant3->attributeValues()->attach([$blue->id, $gb128->id]);
        $variant4->attributeValues()->attach([$blue->id, $gb256->id]);
    }
}
