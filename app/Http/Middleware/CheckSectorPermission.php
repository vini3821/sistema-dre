<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSectorPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $sector)
    {
        $user = Auth::user();

        // Verifique se o setor do usuário corresponde ao setor solicitado
        if ($user->sector !== $sector) {
            return redirect()->route('unauthorized')->with('error', 'Você não tem permissão para acessar este setor.');
        }

        return $next($request);
    }
}
