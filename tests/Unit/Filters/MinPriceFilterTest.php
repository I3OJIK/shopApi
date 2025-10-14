<?php

namespace Tests\Unit\Filters;

use App\Filters\Product\Filters\MinPriceFilter;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MinPriceFilterTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_filters_by_min_price()
    {
        Product::factory()->create(['price' => 50]);
        Product::factory()->create(['price' => 150]);
        Product::factory()->create(['price' => 200]);
        Product::factory()->create(['price' => 99]);

        $filter = new MinPriceFilter();

        $query = $filter->apply(Product::query(), 100);
        $products = $query->get();

        $productsPrice = $products->pluck('price')->toArray();
    
        $this->assertCount(2, $products);
        $this->assertEquals([150, 200], $productsPrice);
    }
}