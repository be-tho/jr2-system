<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    /**
     * Check if current user is admin
     */
    public static function isAdmin(): bool
    {
        return Auth::check() && Auth::user()->isAdmin();
    }

    /**
     * Check if current user has specific role
     */
    public static function hasRole(string $role): bool
    {
        return Auth::check() && Auth::user()->hasRole($role);
    }

    /**
     * Check if current user has any of the given roles
     */
    public static function hasAnyRole(array $roles): bool
    {
        return Auth::check() && Auth::user()->hasAnyRole($roles);
    }

    /**
     * Get current user role
     */
    public static function getCurrentUserRole(): ?string
    {
        return Auth::check() ? Auth::user()->role : null;
    }
}
