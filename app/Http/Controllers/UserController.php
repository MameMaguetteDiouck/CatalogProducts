<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the team members.
     */
    public function index(): View
    {
        Gate::authorize('manage-users');

        $users = User::orderBy('_id', 'desc')->paginate(15);
        $roles = UserRole::cases();

        return view('users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new team member.
     */
    public function create(): View
    {
        Gate::authorize('manage-users');

        $roles = UserRole::cases();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created team member.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('manage-users');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', Password::min(8)],
            'role' => ['required', Rule::enum(UserRole::class)],
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L’adresse e-mail est obligatoire.',
            'email.unique' => 'Cette adresse e-mail est déjà attribuée.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
            'role.required' => 'Le rôle est obligatoire.',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now();

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', "Le compte collaborateur ({$validated['name']}) a été créé avec succès.");
    }

    /**
     * Show the form for editing the specified team member.
     */
    public function edit(string $id): View
    {
        Gate::authorize('manage-users');

        $user = User::findOrFail($id);
        $roles = UserRole::cases();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified team member in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        Gate::authorize('manage-users');

        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::enum(UserRole::class)],
            'password' => ['nullable', 'string', Password::min(8)],
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L’adresse e-mail est obligatoire.',
            'email.unique' => 'Cette adresse e-mail est déjà attribuée.',
            'role.required' => 'Le rôle est obligatoire.',
            'password.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', "Le compte de {$user->name} a été mis à jour.");
    }

    /**
     * Remove the specified team member.
     */
    public function destroy(string $id): RedirectResponse
    {
        Gate::authorize('manage-users');

        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte administrateur.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', "Le compte de {$name} a été supprimé.");
    }
}
