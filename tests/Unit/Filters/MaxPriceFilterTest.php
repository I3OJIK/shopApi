<?php

namespace Tests\Unit\Filters;

use App\Filters\Product\Filters\MaxPriceFilter;
use App\Filters\Product\Filters\MinPriceFilter;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MaxPriceFilterTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_filters_products_by_max_price()
    {
        Product::factory()->create(['price' => 50]);
        Product::factory()->create(['price' => 201]);
        Product::factory()->create(['price' => 200]);
        Product::factory()->create(['price' => 150]);

        $filter = new MaxPriceFilter();

        $query = $filter->apply(Product::query(), 200);
        $products = $query->get();

        $productsPrice = $products->pluck('price')->toArray();
    
        $this->assertCount(3, $products);
        $this->assertEquals([50, 200, 150], $productsPrice);
    }
 
}
