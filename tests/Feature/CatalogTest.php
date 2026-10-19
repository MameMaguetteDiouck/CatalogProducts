<?php

namespace Tests\Feature;

use App\Enums\ProductCategory;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    public function test_home_page_displays_catalog(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('CatalogPro');
    }

    public function test_products_index_lists_products(): void
    {
        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertViewHas('products');
        $response->assertViewHas('categories');
    }

    public function test_products_can_be_filtered_by_category(): void
    {
        $response = $this->get(route('products.index', ['category' => ProductCategory::ALIMENTS->value]));

        $response->assertStatus(200);
        $response->assertViewIs('products.index');
    }

    public function test_default_admin_user_can_authenticate(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@catalog.local',
            'password' => 'Password123!',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticated();
    }
}
