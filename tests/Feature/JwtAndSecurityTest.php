<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use App\Services\JwtAuthService;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class JwtAndSecurityTest extends TestCase
{
    private function getOrCreateUser(string $email, string $role = 'manager', bool $mustChangePassword = false): User
    {
        return User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Utilisateur Test',
                'password' => Hash::make('Password123!'),
                'role' => $role === 'admin' ? UserRole::ADMIN : UserRole::MANAGER,
                'email_verified_at' => now(),
                'must_change_password' => $mustChangePassword,
            ]
        );
    }

    public function test_login_generates_jwt_cookie_and_authenticates_user(): void
    {
        $user = $this->getOrCreateUser('jwt.test@catalog.local');

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'Password123!',
        ]);

        $response->assertRedirect('/products');
        $response->assertCookie(JwtAuthService::COOKIE_NAME);

        $cookie = $response->getCookie(JwtAuthService::COOKIE_NAME);
        $this->assertNotNull($cookie);

        $payload = JwtAuthService::verifyToken($cookie->getValue());
        $this->assertNotNull($payload);
        $this->assertEquals((string) $user->id, $payload['sub']);
        $this->assertEquals($user->email, $payload['email']);

        $user->delete();
    }

    public function test_user_with_must_change_password_is_redirected_to_force_change_page(): void
    {
        $user = $this->getOrCreateUser('temporary.pass@catalog.local', 'manager', true);

        // When logging in, redirect directly to force change
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'Password123!',
        ]);

        $response->assertRedirect(route('password.first_login'));

        // When attempting to access protected catalog while must_change_password is true, redirected back
        $responseAccess = $this->actingAs($user)->get(route('products.index'));
        $responseAccess->assertRedirect(route('password.first_login'));

        $user->delete();
    }

    public function test_user_can_complete_first_login_password_change(): void
    {
        $user = $this->getOrCreateUser('change.first@catalog.local', 'manager', true);

        $response = $this->actingAs($user)->post(route('password.first_login.update'), [
            'current_password' => 'Password123!',
            'password' => 'NewSecurePassword2026!',
            'password_confirmation' => 'NewSecurePassword2026!',
        ]);

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertFalse($user->mustChangePassword());
        $this->assertTrue(Hash::check('NewSecurePassword2026!', $user->password));

        $user->delete();
    }

    public function test_user_can_view_and_update_profile(): void
    {
        $user = $this->getOrCreateUser('profile.test@catalog.local');

        $response = $this->actingAs($user)->get(route('profile.edit'));
        $response->assertStatus(200);
        $response->assertSee('Mon Profil Personnel');
        $response->assertSee($user->name);

        $responseUpdate = $this->actingAs($user)->put(route('profile.update'), [
            'name' => 'Nom Modifié Test',
            'email' => $user->email,
        ]);

        $responseUpdate->assertRedirect(route('profile.edit'));
        $responseUpdate->assertSessionHas('success');

        $user->refresh();
        $this->assertEquals('Nom Modifié Test', $user->name);

        $user->delete();
    }

    public function test_user_can_update_own_password_from_profile(): void
    {
        $user = $this->getOrCreateUser('profile.pwd@catalog.local');

        $response = $this->actingAs($user)->put(route('profile.password'), [
            'current_password' => 'Password123!',
            'password' => 'BrandNewPassword456!',
            'password_confirmation' => 'BrandNewPassword456!',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertTrue(Hash::check('BrandNewPassword456!', $user->password));

        $user->delete();
    }

    public function test_logout_purges_jwt_cookie(): void
    {
        $user = $this->getOrCreateUser('logout.test@catalog.local');

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect(route('login'));
        $response->assertCookieExpired(JwtAuthService::COOKIE_NAME);

        $user->delete();
    }

    public function test_smtp_password_reset_routes_are_disabled(): void
    {
        $response = $this->get('/password/reset');
        $response->assertStatus(404);
    }
}
