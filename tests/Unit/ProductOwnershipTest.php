<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Manufacturer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

class ProductOwnershipTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_handles_legacy_product_ownership()
    {
        // Create a product with legacy seller_id
        $product = new Product([
            'name' => 'Test Product',
            'seller_id' => 1,
            'manufacturer_id' => null,
        ]);

        // Test legacy accessibility scope
        $owner = [
            'role' => 'seller',
            'model' => (object) ['id' => 1]
        ];

        // This should work even without polymorphic columns
        $query = Product::query()->accessibleBy($owner);
        
        // The query should be built without errors
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, $query);
    }

    /** @test */
    public function it_handles_polymorphic_product_ownership()
    {
        // Skip if polymorphic columns don't exist
        if (!Schema::hasColumn('products', 'owner_type')) {
            $this->markTestSkipped('Polymorphic columns not available');
        }

        // Create a product with polymorphic ownership
        $product = new Product([
            'name' => 'Test Product',
            'owner_type' => 'App\\Models\\Seller',
            'owner_id' => 1,
        ]);

        // Test polymorphic accessibility scope
        $owner = [
            'role' => 'seller',
            'type' => 'App\\Models\\Seller',
            'model' => (object) ['id' => 1, 'salesmen' => collect()]
        ];

        $query = Product::query()->accessibleBy($owner);
        
        // The query should be built without errors
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, $query);
    }

    /** @test */
    public function it_filters_by_owner_type_with_fallback()
    {
        $query = Product::query()->byOwnerType('App\\Models\\Seller');
        
        // Should work regardless of column existence
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, $query);
    }

    /** @test */
    public function it_filters_by_specific_owner_with_fallback()
    {
        $query = Product::query()->byOwner('App\\Models\\Seller', 1);
        
        // Should work regardless of column existence
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, $query);
    }
}