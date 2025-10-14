<?php

namespace Tests\Unit\Filters;

use App\Filters\Product\Filters\SearchFilter;
use App\Filters\Product\Filters\SortFilter;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SortFilterTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_filters_by_sort_price_asc()
    {
        Product::factory()->create(['price' => 300]);
        Product::factory()->create(['price' => 500]);
        Product::factory()->create(['price' => 200]);
        Product::factory()->create(['price' => 400]);

        $filter = new SortFilter();

        $query = $filter->apply(Product::query(), 'price_asc');
        $products = $query->get();

        $this->assertEquals('200', $products->first()->price);
    }
}