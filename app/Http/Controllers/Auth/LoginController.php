<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/products';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * The user has been authenticated.
     */
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        $token = \App\Services\JwtAuthService::generateToken($user);
        $cookie = \App\Services\JwtAuthService::makeCookie($token);

        if ($user->mustChangePassword()) {
            return redirect()->route('password.first_login')
                ->withCookie($cookie)
                ->with('warning', 'Bienvenue sur CatalogPro. Pour des raisons de sécurité, vous devez définir votre propre mot de passe.');
        }

        return redirect()->intended($this->redirectPath())->withCookie($cookie);
    }

    /**
     * The user has logged out of the application.
     */
    protected function loggedOut(\Illuminate\Http\Request $request)
    {
        return redirect()->route('login')
            ->withCookie(\App\Services\JwtAuthService::forgetCookie())
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
