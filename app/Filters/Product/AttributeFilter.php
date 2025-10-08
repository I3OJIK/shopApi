<?php

namespace App\Filters\Product;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Builder;

class AttributeFilter implements FilterInterface 
{
    /**
     * Фильтрация по атрибутам пример [name => 'color', value => ['синий', 'красный']]
     * 
     * @param Builder $query
     * @param mixed $attributes
     * 
     * @return Builder
     */
    public function apply(Builder $query, mixed $attributes): Builder
    {
        foreach ($attributes as $attribute) {
            $name = $attribute['name'];
            $values = $attribute['values'];

            $placeholders = rtrim(str_repeat('?,', count($values)), ',');
            $bindings = array_merge([$name], $values);

            $sql = <<<SQL
            SELECT *
            FROM products p
                WHERE EXISTS (
                    SELECT 1
                    FROM product_variants pv
                        INNER JOIN product_variant_values pvv ON pv.id = pvv.product_variant_id
                        INNER JOIN attribute_values av ON av.id = pvv.attribute_value_id
                        INNER JOIN attributes a ON a.id = av.attribute_id
                        WHERE pv.product_id = p.id
                            AND a.name = ?
                            AND av.value IN ($placeholders)
                )
            SQL;

            $query->whereRaw($sql, $bindings);
        }
        return $query;
    }
}
