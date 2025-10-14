<?php

namespace Tests\Unit\Filters;

use App\Filters\Product\Filters\SearchFilter;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SearchFilterTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_filters_by_search_term()
    {
        Product::factory()->create(['name' => 'Apple Iphone 14']);
        Product::factory()->create(['name' => 'Samsung']);
        Product::factory()->create(['name' => 'App']);

        $filter = new SearchFilter();

        $query = $filter->apply(Product::query(), 'Iphone');
        $products = $query->get();

        $this->assertCount(1, $products);
        $this->assertEquals('Apple Iphone 14', $products->first()->name);
    }
}