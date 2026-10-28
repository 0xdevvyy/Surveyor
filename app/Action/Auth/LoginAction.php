<?php

declare(strict_types=1);

namespace App\Action\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

final readonly class LoginAction
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function login(array $data): RedirectResponse
    {

        if (! Auth::attempt($data)) {
            Inertia::flash('toast', [
                'type' => 'error',
                'message' => 'Engk Error!!',
            ]);

            return back();
        }

        $role = Auth::user()->role;

        // dd($role);

        request()->session()->regenerate();
        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Login Successfully!',
        ]);

        return match ($role->value) {
            'admin' => to_route('auth.admin.dashboard'),
            'surveyor' => to_route('auth.surveyor.dashboard'),
            'resident' => to_route('auth.resident.dashboard'),
            // default => to_route('index.auth'),
        };
    }
}
