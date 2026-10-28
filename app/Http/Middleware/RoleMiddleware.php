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

        abort_unless($user !== null, 404);

        $allowedRoles = array_map(
            RoleEnum::tryFrom(...),
            $roles
        );

        abort_unless(
            in_array($user->role, array_filter($allowedRoles), true),
            404
        );

        return $next($request);
    }
}
