<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordIsChanged
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->mustChangePassword()) {
            $allowedRoutes = [
                'password.first_login',
                'password.first_login.update',
                'logout',
            ];

            if (! in_array($request->route()?->getName(), $allowedRoutes, true)) {
                return redirect()->route('password.first_login')
                    ->with('warning', 'Pour des raisons de sécurité, vous devez définir votre mot de passe personnel avant d’accéder à la plateforme.');
            }
        }

        return $next($request);
    }
}
