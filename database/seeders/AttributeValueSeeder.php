<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AttributeValue;

class AttributeValueSeeder extends Seeder
{
    public function run(): void
    {
        AttributeValue::insert([
            // цвет
            ['attribute_id' => 1, 'value' => 'черный'],
            ['attribute_id' => 1, 'value' => 'белый'],
            ['attribute_id' => 1, 'value' => 'синий'],
            ['attribute_id' => 1, 'value' => 'красный'],
            ['attribute_id' => 1, 'value' => 'фиолетовый'],
            ['attribute_id' => 1, 'value' => 'зеленый'],
            ['attribute_id' => 1, 'value' => 'золотой'],
            ['attribute_id' => 1, 'value' => 'серебристый'],

             // Память (Storage)
            ['attribute_id' => 2, 'value' => '64GB'],
            ['attribute_id' => 2, 'value' => '128GB'],
            ['attribute_id' => 2, 'value' => '256GB'],
            ['attribute_id' => 2, 'value' => '512GB'],
            ['attribute_id' => 2, 'value' => '1TB'],

            // Оперативная память (RAM)
            ['attribute_id' => 3, 'value' => '4GB'],
            ['attribute_id' => 3, 'value' => '6GB'],
            ['attribute_id' => 3, 'value' => '8GB'],
            ['attribute_id' => 3, 'value' => '12GB'],
            ['attribute_id' => 3, 'value' => '16GB'],

            // Процессор
            ['attribute_id' => 4, 'value' => 'Snapdragon 8 Gen 2'],
            ['attribute_id' => 4, 'value' => 'Snapdragon 8 Gen 1'],
            ['attribute_id' => 4, 'value' => 'Apple A16 Bionic'],
            ['attribute_id' => 4, 'value' => 'Apple A15 Bionic'],
            ['attribute_id' => 4, 'value' => 'Exynos 2200'],
            ['attribute_id' => 4, 'value' => 'MediaTek Dimensity 9000'],

        ]);
    }
}
