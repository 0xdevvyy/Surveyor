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

        request()->session()->regenerate();
        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Login Successfully!',
        ]);

        return to_route('dashboard'); // for now will be this placeholder dashboard
    }
}
