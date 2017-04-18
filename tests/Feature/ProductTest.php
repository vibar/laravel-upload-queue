<?php

namespace Tests\Feature;

use App\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testProductsImport()
    {
        $response = $this->get('/product/create');

        $response->assertStatus(200);
    }

    public function testListProducts()
    {
        $response = $this->get('/product');

        $response->assertStatus(200);
    }
}
