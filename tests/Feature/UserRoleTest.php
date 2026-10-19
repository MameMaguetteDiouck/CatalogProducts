<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    private function getOrCreateAdmin(): User
    {
        $admin = User::where('role', UserRole::ADMIN->value)->first();
        if (! $admin) {
            $admin = User::create([
                'name' => 'Admin Test',
                'email' => 'admin.test@catalog.local',
                'password' => Hash::make('Password123!'),
                'role' => UserRole::ADMIN,
                'email_verified_at' => now(),
            ]);
        }
        return $admin;
    }

    private function getOrCreateManager(): User
    {
        $manager = User::where('role', UserRole::MANAGER->value)->first();
        if (! $manager) {
            $manager = User::create([
                'name' => 'Manager Test',
                'email' => 'manager.test@catalog.local',
                'password' => Hash::make('Password123!'),
                'role' => UserRole::MANAGER,
                'email_verified_at' => now(),
            ]);
        }
        return $manager;
    }

    public function test_admin_can_access_team_management_page(): void
    {
        $admin = $this->getOrCreateAdmin();

        $response = $this->actingAs($admin)->get(route('users.index'));

        $response->assertStatus(200);
        $response->assertSee('Ajouter un Collaborateur');
        $response->assertSee('Espace Catalogue');
    }

    public function test_manager_cannot_access_team_management_page(): void
    {
        $manager = $this->getOrCreateManager();

        $response = $this->actingAs($manager)->get(route('users.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_create_new_manager(): void
    {
        $admin = $this->getOrCreateAdmin();
        $uniqueEmail = 'collab.' . uniqid() . '@catalog.local';

        $response = $this->actingAs($admin)->post(route('users.store'), [
            'name' => 'Nouveau Collaborateur',
            'email' => $uniqueEmail,
            'role' => UserRole::MANAGER->value,
            'password' => 'SecurePass123!',
        ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success');

        $created = User::where('email', $uniqueEmail)->first();
        $this->assertNotNull($created);
        $this->assertEquals(UserRole::MANAGER, $created->role);
        $this->assertTrue(Hash::check('SecurePass123!', $created->password));

        $created->delete();
    }

    public function test_admin_cannot_delete_own_account(): void
    {
        $admin = $this->getOrCreateAdmin();

        $response = $this->actingAs($admin)->delete(route('users.destroy', $admin->id));

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('error');
    }

    public function test_admin_can_delete_product(): void
    {
        $admin = $this->getOrCreateAdmin();
        $product = Product::create([
            'libelle' => 'Produit temporaire test',
            'prix' => 5000,
            'type' => 'alimentaire',
            'stock' => 10,
            'description' => 'Test suppression admin',
        ]);

        $response = $this->actingAs($admin)->delete(route('products.destroy', $product->id));

        $response->assertRedirect(route('products.index', ['category' => 'alimentaire']));
        $response->assertSessionHas('success');
        $this->assertNull(Product::find($product->id));
    }

    public function test_manager_cannot_delete_product(): void
    {
        $manager = $this->getOrCreateManager();
        $product = Product::create([
            'libelle' => 'Produit protégé test',
            'prix' => 12000,
            'type' => 'materiel',
            'stock' => 5,
            'description' => 'Test interdiction manager',
        ]);

        $response = $this->actingAs($manager)->delete(route('products.destroy', $product->id));

        $response->assertStatus(403);
        $this->assertNotNull(Product::find($product->id));

        $product->delete();
    }
}
