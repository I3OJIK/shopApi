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

        $products = Product::insert([
            // Смартфоны Apple
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Флагманский смартфон Apple с титановым корпусом и камерой 48 МП',
                'category_id' => 2
            ],
            [
                'name' => 'iPhone 15', 
                'description' => 'Стандартная модель iPhone 15 с динамическим островом',
                'category_id' => 2
                
            ],
            [
                'name' => 'iPhone 14 Pro',
                'description' => 'Мощный смартфон с Always-On дисплеем и камерой 48 МП',
                'category_id' => 2
            ],
            [
                'name' => 'iPhone 14',
                'description' => 'Популярная модель iPhone с отличной производительностью',
                'category_id' => 2
            ],
            [
                'name' => 'iPhone SE (2022)',
                'description' => 'Компактный смартфон в классическом дизайне',
                'category_id' => 2
            ],

            // Смартфоны Samsung
            [
                'name' => 'Samsung Galaxy S23 Ultra',
                'description' => 'Флагман Samsung с S-Pen и 200 МП камерой',
                'category_id' => 2
            ],
            [
                'name' => 'Samsung Galaxy S23+',
                'description' => 'Мощный смартфон с большим экраном и быстрой зарядкой',
                'category_id' => 2
            ],
            [
                'name' => 'Samsung Galaxy S23',
                'description' => 'Компактный флагман с отличной эргономикой',
                'category_id' => 2
            ],
            [
                'name' => 'Samsung Galaxy Z Fold5',
                'description' => 'Складной смартфон с большим экраном',
                'category_id' => 2
            ],
            [
                'name' => 'Samsung Galaxy Z Flip5',
                'description' => 'Складной смартфон-раскладушка',
                'category_id' => 2
            ],
            [
                'name' => 'Samsung Galaxy A54',
                'description' => 'Бюджетный смартфон с хорошей камерой',
                'category_id' => 2
            ],

            // Смартфоны Xiaomi
            [
                'name' => 'Xiaomi 13 Pro',
                'description' => 'Флагман Xiaomi с камерой Leica',
                'category_id' => 2
            ],
            [
                'name' => 'Xiaomi 13',
                'description' => 'Компактный флагман от Xiaomi',
                'category_id' => 2
            ],
            [
                'name' => 'Xiaomi Redmi Note 12 Pro',
                'description' => 'Популярный смартфон среднего класса',
                'category_id' => 2
            ],
            [
                'name' => 'Xiaomi Poco F5',
                'description' => 'Игровой смартфон с мощным процессором',
                'category_id' => 2
            ],

            // Смартфоны Google
            [
                'name' => 'Google Pixel 8 Pro',
                'description' => 'Смартфон Google с лучшей камерой на рынке',
                'category_id' => 2
            ],
            [
                'name' => 'Google Pixel 8',
                'description' => 'Компактный Pixel с чистым Android',
                'category_id' => 2
            ],
            [
                'name' => 'Google Pixel 7a',
                'description' => 'Бюджетная версия Pixel с отличной камерой',
                'category_id' => 2
            ],

            // Другие бренды
            [
                'name' => 'OnePlus 11',
                'description' => 'Флагман с быстрой зарядкой 100W',
                'category_id' => 2
            ],
            [
                'name' => 'Nothing Phone (2)',
                'description' => 'Уникальный дизайн со светодиодной подсветкой',
                'category_id' => 2
            ],
            [
                'name' => 'Realme GT 3',
                'description' => 'Игровой смартфон с зарядкой 240W',
                'category_id' => 2
            ],
            [
                'name' => 'Vivo X90 Pro',
                'description' => 'Флагман с камерой Zeiss',
                'category_id' => 2
            ],
            [
                'name' => 'Oppo Find X6 Pro',
                'description' => 'Мощный смартфон с ярким дисплеем',
                'category_id' => 2
            ],
        ]);

    }
}
