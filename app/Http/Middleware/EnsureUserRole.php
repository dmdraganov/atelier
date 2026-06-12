<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();
        $allowedRoles = collect($roles)->map(fn (string $role): UserRole => UserRole::from($role));

        abort_unless($user && $allowedRoles->contains($user->role), 403);

        return $next($request);
    }
}
