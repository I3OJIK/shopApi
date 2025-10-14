<?php

namespace Tests\Feature\Services;

use App\Data\Requests\Product\ProductFilterData;
use App\Services\ProductService;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ProductService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(ProductService::class);
    }

    #[Test]
    public function it_returns_paginated_products_with_filters_applied()
    {
        Product::factory()->create(['name' => 'Apple 14 pro blue', 'price' => 50]);
        Product::factory()->create(['name' => 'Iphone Apple 17 pro gray', 'price' => 500]);
        Product::factory()->create(['name' => 'Samsung A5  white', 'price' => 150]);

        // Фильтрация
        $data = new ProductFilterData(
            search: 'Apple',
            minPrice: 10,
            maxPrice: 200,
            sort: 'price_asc',
            perPage: 10
        );

        $result = $this->service->list($data);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertCount(1, $result->items());
        $this->assertEquals('Apple 14 pro blue', $result->items()[0]->name);
    }
}
