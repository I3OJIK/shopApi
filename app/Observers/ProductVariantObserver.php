<?php

namespace App\Observers;

use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class ProductVariantObserver
{

    public function saved(ProductVariant $productVariant): void
    {
        // dd($this->generateFullName($productVariant));
        $productVariant->full_name = $this->generateFullName($productVariant);
        $productVariant->saveQuietly();
    }

    /**
     * Генерация полного имени варианта товара (имя товара плюс его атрибуты)
     * 
     * @param ProductVariant $variant
     * 
     * @return string
     */
    protected function generateFullName(ProductVariant $productVariant): string
    {
 
        $attributes = $productVariant->attributeValues()
            ->pluck('value')
            ->implode(', ');
        dd($productVariant->attributeValues);
        $fullName = $productVariant->product->name . $attributes;

        return $fullName;
    }

}
