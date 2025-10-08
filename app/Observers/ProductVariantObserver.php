<?php

namespace App\Observers;

use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class ProductVariantObserver
{
    /**
     * Handle the ProductVariant "created" event.
     */
    public function saved(ProductVariant $productVariant): void
    {
        $this->updateProductPrice($productVariant);
    }

    /**
     * Handle the ProductVariant "updated" event.
     */
    public function deleted(ProductVariant $productVariant): void
    {
        $this->updateProductPrice($productVariant);
    }

    /**
     * Обновление полей мин и макс цена в таблице Product
     * 
     * @param ProductVariant $variant
     * 
     * @return void
     */
    protected function updateProductPrice(ProductVariant $variant): void
    {
        $product = $variant->product;

        $sql = <<<SQL
        SELECT
            MIN(price) AS "min_price",
            MAX(price) AS "max_price"
        FROM
            "product_variants"
        WHERE
            product_id = ?
        SQL;

        $priceRange = DB::selectOne($sql, [$product->id]);

        $product->update([
            'min_price' => $priceRange->min_price,
            'max_price' => $priceRange->max_price
        ]);
    }

}
