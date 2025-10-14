<?php

namespace Tests\Unit\Filters;

use App\Filters\Product\Filters\ProductGroupFilter;
use App\Filters\Product\Filters\SortFilter;
use App\Models\Product;
use App\Models\ProductGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductGroupFilterTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_filters_by_product_group()
    {
        $groupA = ProductGroup::factory()->create();
        $groupB = ProductGroup::factory()->create();

        Product::factory()->create(['product_group_id' => $groupA->id]);
        Product::factory()->create(['product_group_id' => $groupA->id]);
        Product::factory()->create(['product_group_id' => $groupB->id]);
        Product::factory()->create(['product_group_id' => $groupA->id]);

        $filter = new ProductGroupFilter();

        $query = $filter->apply(Product::query(), $groupA->id);
        $products = $query->get();

        $this->assertCount(3, $products);

    }
}