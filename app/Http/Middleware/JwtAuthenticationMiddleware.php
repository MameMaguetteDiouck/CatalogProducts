<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\JwtAuthService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class JwtAuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie(JwtAuthService::COOKIE_NAME) ?? $request->bearerToken();

        if ($token) {
            $payload = JwtAuthService::verifyToken($token);

            if ($payload && isset($payload['sub'])) {
                // If the user isn't logged in yet in the current session, authenticate them via the JWT subject
                if (! Auth::check()) {
                    $user = User::find($payload['sub']);
                    if ($user) {
                        Auth::login($user);
                    }
                }
            } elseif ($request->hasCookie(JwtAuthService::COOKIE_NAME)) {
                // Invalid or expired token: clear the session and forget the cookie
                Auth::logout();
                $response = $next($request);
                $response->headers->setCookie(JwtAuthService::forgetCookie());
                return $response;
            }
        }

        return $next($request);
    }
}
