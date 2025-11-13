<?php

namespace Tests\Browser;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProductCrudTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testCreateProduct()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/products')
                ->pause(2000)
                ->click('a.btn-primary') // Simple class selector
                ->pause(2000)
                ->type('name', 'Laptop Gaming')
                ->type('description', 'High performance gaming laptop')
                ->type('price', '15000000')
                ->type('stock', '10')
                ->press('Create')
                ->pause(2000)
                ->assertSee('Product created successfully.')
                ->assertSee('Laptop Gaming');
        });
    }

    public function testReadProduct()
    {
        $product = Product::factory()->create([
            'name' => 'Test Product Dusk',
            'price' => 100000,
            'stock' => 5
        ]);

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/products')
                ->pause(2000)
                ->assertSee('Test Product Dusk')
                ->click('@view-product-' . $product->id)
                ->pause(2000)
                ->assertSee('Test Product Dusk')
                ->assertSee('100,000.00')
                ->assertSee('5');
        });
    }

    public function testUpdateProduct()
    {
        $product = Product::factory()->create([
            'name' => 'Old Product Name',
            'price' => 50000,
            'stock' => 3
        ]);

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/products')
                ->pause(2000)
                ->click('@edit-product-' . $product->id)
                ->pause(2000)
                ->type('name', 'Updated Product Name')
                ->type('price', '75000')
                ->type('stock', '8')
                ->press('Update')
                ->pause(2000)
                ->assertSee('Product updated successfully.')
                ->assertSee('Updated Product Name');
        });
    }

    public function testDeleteProduct()
    {
        $product = Product::factory()->create([
            'name' => 'Product to Delete Dusk'
        ]);

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/products')
                ->pause(2000)
                ->assertSee('Product to Delete Dusk')
                ->press('@delete-product-' . $product->id)
                ->waitForDialog()
                ->acceptDialog()
                ->pause(2000)
                ->assertSee('Product deleted successfully.')
                ->assertDontSee('Product to Delete Dusk');
        });
    }

    public function testValidation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/products/create')
                ->pause(2000)
                ->press('Create')
                ->pause(3000)
                ->assertSee('The name field is required')
                ->assertSee('The price field is required')
                ->assertSee('The stock field is required');
        });
    }
}