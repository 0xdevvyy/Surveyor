<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Action\Auth\LoginAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SessionsController extends Controller
{
    public function login(): Response
    {
        return Inertia::render('auth/login');
    }

    public function storeSession(LoginRequest $request, LoginAction $action): RedirectResponse
    {
        // dd($password, $email);

        return $action->login($request->safe()->all());
    }
}
