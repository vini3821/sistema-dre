<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
    public function store(Request $request): RedirectResponse
    {
        $request->session()->regenerate();

        return redirect()->intended('/dre'); // Mude '/dre' para a rota desejada.
    }

}
