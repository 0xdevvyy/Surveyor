<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enum\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        $allowedRoles = array_filter(array_map(RoleEnum::tryFrom(...), $roles));

        abort_unless($user !== null && in_array($user->role, $allowedRoles, true), 404);

        return $next($request);
    }
}
