<?php

namespace App\Services;

use App\Models\User;
use Symfony\Component\HttpFoundation\Cookie;

class JwtAuthService
{
    public const COOKIE_NAME = 'catalog_jwt_token';
    public const DEFAULT_TTL_MINUTES = 480; // 8 heures

    /**
     * Generate an RFC 7519 compliant JWT for the given user.
     */
    public static function generateToken(User $user, int $ttlMinutes = self::DEFAULT_TTL_MINUTES): string
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
        ];

        $now = time();
        $payload = [
            'iss' => config('app.url', 'http://127.0.0.1:8000'),
            'sub' => (string) $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'role' => $user->role instanceof \App\Enums\UserRole ? $user->role->value : (string) $user->role,
            'must_change_password' => (bool) $user->must_change_password,
            'iat' => $now,
            'exp' => $now + ($ttlMinutes * 60),
            'jti' => bin2hex(random_bytes(16)),
        ];

        $encodedHeader = self::base64UrlEncode((string) json_encode($header, JSON_UNESCAPED_SLASHES));
        $encodedPayload = self::base64UrlEncode((string) json_encode($payload, JSON_UNESCAPED_SLASHES));

        $signature = hash_hmac('sha256', "{$encodedHeader}.{$encodedPayload}", self::getSecret(), true);
        $encodedSignature = self::base64UrlEncode($signature);

        return "{$encodedHeader}.{$encodedPayload}.{$encodedSignature}";
    }

    /**
     * Verify and decode a JWT. Returns the payload array if valid, null otherwise.
     */
    public static function verifyToken(string $token): ?array
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return null;
        }

        [$encodedHeader, $encodedPayload, $encodedSignature] = $parts;

        // Verify HMAC-SHA256 signature in constant time
        $expectedSignature = hash_hmac('sha256', "{$encodedHeader}.{$encodedPayload}", self::getSecret(), true);
        $providedSignature = self::base64UrlDecode($encodedSignature);

        if (! hash_equals($expectedSignature, $providedSignature)) {
            return null;
        }

        // Decode header and payload
        $header = json_decode(self::base64UrlDecode($encodedHeader), true);
        $payload = json_decode(self::base64UrlDecode($encodedPayload), true);

        if (! is_array($header) || ($header['alg'] ?? '') !== 'HS256' || ! is_array($payload)) {
            return null;
        }

        // Verify expiration
        $now = time();
        if (isset($payload['exp']) && $now >= $payload['exp']) {
            return null;
        }

        // Verify issued-at
        if (isset($payload['iat']) && $now < ($payload['iat'] - 60)) {
            return null;
        }

        return $payload;
    }

    /**
     * Create a secure HttpOnly cookie containing the JWT.
     */
    public static function makeCookie(string $token, int $ttlMinutes = self::DEFAULT_TTL_MINUTES): Cookie
    {
        $isSecure = request()->isSecure() || app()->environment('production');

        return Cookie::create(
            name: self::COOKIE_NAME,
            value: $token,
            expire: time() + ($ttlMinutes * 60),
            path: '/',
            domain: null,
            secure: $isSecure,
            httpOnly: true,
            raw: false,
            sameSite: Cookie::SAMESITE_LAX
        );
    }

    /**
     * Create an expired cookie to purge the JWT on logout.
     */
    public static function forgetCookie(): Cookie
    {
        return Cookie::create(
            name: self::COOKIE_NAME,
            value: null,
            expire: time() - 86400,
            path: '/',
            domain: null,
            secure: request()->isSecure() || app()->environment('production'),
            httpOnly: true,
            raw: false,
            sameSite: Cookie::SAMESITE_LAX
        );
    }

    /**
     * Base64URL encode string.
     */
    public static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Base64URL decode string.
     */
    public static function base64UrlDecode(string $data): string
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }

        return (string) base64_decode(strtr($data, '-_', '+/'));
    }

    /**
     * Retrieve the signing secret key.
     */
    private static function getSecret(): string
    {
        $key = config('app.key');
        if (str_starts_with($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        return (string) $key;
    }
}
