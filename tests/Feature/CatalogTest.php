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

    public function test_authenticated_user_sees_profile_and_logout_on_homepage_and_management(): void
    {
        $user = User::first();
        $this->assertNotNull($user);

        $responseHome = $this->actingAs($user)->get('/');
        $responseHome->assertStatus(200);
        $responseHome->assertSee('Déconnexion');
        $responseHome->assertSee($user->name);

        $responseMgmt = $this->actingAs($user)->get(route('products.index'));
        $responseMgmt->assertStatus(200);
        $responseMgmt->assertSee('Déconnexion');
        $responseMgmt->assertSee($user->name);
    }

    public function test_authenticated_user_can_access_product_create_form(): void
    {
        $user = User::first();
        $this->assertNotNull($user);

        $response = $this->actingAs($user)->get(route('products.create'));

        $response->assertStatus(200);
        $response->assertSee("Création d'une Nouvelle Référence", false);
        $response->assertSee('Désignation du produit');
        $response->assertSee('Prix unitaire (FCFA)');
    }

    public function test_authenticated_user_can_store_new_product_with_category_attributes(): void
    {
        $user = User::first();
        $this->assertNotNull($user);

        $productData = [
            'libelle' => 'Bazin Riche Sénégalais Test',
            'prix' => 45000,
            'stock' => 15,
            'type' => 'habillements',
            'description' => 'Tissu bazin brodé de haute qualité pour cérémonies traditionnelles.',
            'marque' => 'Getzner Prestige',
            'taille' => 'Grand Boubou (XL)',
        ];

        $response = $this->actingAs($user)->post(route('products.store'), $productData);

        $response->assertRedirect(route('products.index', ['category' => 'habillements']));
        $response->assertSessionHas('success');

        $created = Product::where('libelle', 'Bazin Riche Sénégalais Test')->first();
        $this->assertNotNull($created);
        $this->assertEquals(45000, $created->prix);
        $this->assertEquals('Getzner Prestige', $created->marque);
        $this->assertEquals('Grand Boubou (XL)', $created->taille);
        $this->assertEquals('45 000 FCFA', $created->formattedPrice());

        $created->delete();
    }

    public function test_storing_product_with_zero_stock_saves_as_integer_and_increments_out_of_stock_count(): void
    {
        $user = User::first();
        $this->assertNotNull($user);

        $initialOutOfStock = Product::outOfStock()->count();

        $productData = [
            'libelle' => 'Chapeau Traditionnel Test Rupture',
            'prix' => 12000,
            'stock' => 0,
            'type' => 'habillements',
            'description' => 'Chapeau en paille tressée du Fouta.',
            'marque' => 'Artisanat Nord',
            'taille' => 'M',
        ];

        $response = $this->actingAs($user)->post(route('products.store'), $productData);

        $response->assertRedirect(route('products.index', ['category' => 'habillements']));
        $response->assertSessionHas('success');

        $created = Product::where('libelle', 'Chapeau Traditionnel Test Rupture')->first();
        $this->assertNotNull($created);
        $this->assertSame(0, $created->stock);
        $this->assertSame(12000.0, (float) $created->prix);

        $newOutOfStock = Product::outOfStock()->count();
        $this->assertEquals($initialOutOfStock + 1, $newOutOfStock);

        // Management index view should display the out-of-stock count
        $indexResponse = $this->actingAs($user)->get(route('products.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertViewHas('outOfStockCount', $newOutOfStock);

        $created->delete();
    }

    public function test_filtering_products_by_stock_status(): void
    {
        $user = User::first();
        $this->assertNotNull($user);

        // Filter out of stock
        $responseOutOfStock = $this->actingAs($user)->get(route('products.index', ['stock_status' => 'out_of_stock']));
        $responseOutOfStock->assertStatus(200);
        $responseOutOfStock->assertSee('Ruptures');

        // Filter in stock
        $responseInStock = $this->actingAs($user)->get(route('products.index', ['stock_status' => 'in_stock']));
        $responseInStock->assertStatus(200);
        $responseInStock->assertSee('En stock');
    }

    public function test_updating_product_stock_from_zero_to_positive_moves_it_to_in_stock(): void
    {
        $user = User::first();
        $this->assertNotNull($user);

        $product = Product::create([
            'libelle' => 'Transition Stock Test',
            'prix' => 8000,
            'stock' => 0,
            'type' => 'habillements',
            'description' => 'Test transition stock description.',
            'marque' => 'Marque Test',
        ]);

        $this->assertEquals(0, $product->stock);
        $outOfStockBefore = Product::outOfStock()->count();

        $response = $this->actingAs($user)->put(route('products.update', $product->id), [
            'libelle' => 'Transition Stock Test Modifié',
            'prix' => 8500,
            'stock' => 10,
            'type' => 'habillements',
            'description' => 'Test transition stock description.',
            'marque' => 'Marque Test',
        ]);

        $response->assertRedirect();
        $product->refresh();

        $this->assertSame(10, $product->stock);
        $this->assertEquals($outOfStockBefore - 1, Product::outOfStock()->count());

        $product->delete();
    }

    public function test_management_space_supports_custom_per_page_pagination(): void
    {
        $user = User::first();
        $this->assertNotNull($user);

        $response = $this->actingAs($user)->get(route('products.index', ['per_page' => 24]));

        $response->assertStatus(200);
        $response->assertViewHas('perPage', 24);
        $response->assertSessionHas('catalog_per_page', 24);
        $response->assertSee('per-page-segmented');
        $response->assertSee('modern-pagination');
        $response->assertSee('Catalogue complet');
    }
}
