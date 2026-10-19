<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\JwtAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ForcePasswordChangeController extends Controller
{
    /**
     * Show the mandatory password change form.
     */
    public function showChangeForm(): View|RedirectResponse
    {
        $user = Auth::user();

        if (! $user->mustChangePassword()) {
            return redirect()->route('products.index');
        }

        return view('auth.passwords.force_change');
    }

    /**
     * Handle the submission of the new password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', Password::min(8), 'confirmed', 'different:current_password'],
        ], [
            'current_password.required' => 'Le mot de passe actuel/temporaire est obligatoire.',
            'current_password.current_password' => 'Le mot de passe actuel est incorrect.',
            'password.required' => 'Le nouveau mot de passe est obligatoire.',
            'password.min' => 'Le nouveau mot de passe doit comporter au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'password.different' => 'Le nouveau mot de passe doit être différent du mot de passe temporaire.',
        ]);

        $user->password = Hash::make($request->password);
        $user->must_change_password = false;
        $user->save();

        // Regenerate JWT with updated claims
        $token = JwtAuthService::generateToken($user);
        $cookie = JwtAuthService::makeCookie($token);

        return redirect()->route('products.index')
            ->withCookie($cookie)
            ->with('success', 'Votre mot de passe a été sécurisé avec succès. Bienvenue sur votre espace CatalogPro.');
    }
}
