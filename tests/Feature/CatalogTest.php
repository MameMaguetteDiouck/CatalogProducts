<?php

namespace Tests\Feature;

use App\Enums\ProductCategory;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    public function test_home_page_displays_catalog_for_guests_without_management_menu(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('CatalogPro');
        $response->assertDontSee('Espace Gestion');
    }

    public function test_guests_can_view_product_details_without_edit_buttons(): void
    {
        $product = Product::first();
        $this->assertNotNull($product);

        $response = $this->get(route('products.show', $product->id));

        $response->assertStatus(200);
        $response->assertSee($product->libelle);
        $response->assertDontSee('Modifier la fiche');
        $response->assertDontSee('Supprimer');
    }

    public function test_management_space_redirects_unauthenticated_guests(): void
    {
        $response = $this->get(route('products.index'));

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_access_management_space(): void
    {
        $user = User::first();
        $this->assertNotNull($user);

        $response = $this->actingAs($user)->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertViewHas('products');
        $response->assertViewHas('categories');
        $response->assertSee('Nouveau Produit');
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
