<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class VerificaRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user || !$user->roles()->whereIn('name', $roles)->exists()) {
            abort(403, 'Acesso negado.');
        }

        return $next($request);
    }
}
