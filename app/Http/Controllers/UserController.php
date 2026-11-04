<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Container\Attributes\Authenticated;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function destroy(
        #[Authenticated] User $authenticatedUser,
        User $user,
    ): RedirectResponse {
        abort_if($user->is($authenticatedUser), 403);

        $user->delete();

        return to_route('auth.admin.dashboard');
    }
}
