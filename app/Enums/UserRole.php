<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';

    /**
     * Human readable label in French.
     */
    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrateur',
            self::MANAGER => 'Gestionnaire',
        };
    }

    /**
     * Bootstrap badge class for UI styling.
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::ADMIN => 'bg-primary',
            self::MANAGER => 'bg-secondary',
        };
    }

    /**
     * Quick boolean check.
     */
    public function isAdmin(): bool
    {
        return $this === self::ADMIN;
    }
}
