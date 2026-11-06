<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enum\RoleEnum;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Queries\UsersQuery;
use Illuminate\Container\Attributes\Authenticated;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(Request $request, UsersQuery $usersQuery): Response
    {
        $validated = $request->validate([
            'role' => [
                'nullable',
                Rule::in([
                    RoleEnum::SURVEYOR->value,
                    RoleEnum::RESIDENT->value,
                ]),
            ],
            'search' => ['nullable', 'string', 'max:100'],
        ]);
        $role = isset($validated['role'])
            ? RoleEnum::from($validated['role'])
            : null;
        $search = trim($validated['search'] ?? '') ?: null;
        $lengthAwarePaginator = $usersQuery
            ->queryForAdmin($role, $search)
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('users/Index', [
            'users' => [
                ...$lengthAwarePaginator->toArray(),
                'data' => UserResource::collection($lengthAwarePaginator)
                    ->resolve($request),
            ],
            'filters' => [
                'role' => $role?->value,
                'search' => $search,
            ],
        ]);
    }

    public function destroy(
        #[Authenticated] User $authenticatedUser,
        User $user,
    ): RedirectResponse {
        abort_if($user->is($authenticatedUser), 403);

        $user->delete();

        return to_route('auth.admin.dashboard');
    }
}
