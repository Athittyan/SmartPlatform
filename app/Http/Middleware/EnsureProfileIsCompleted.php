<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfProfileCompleted
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->profile_completed) {
            // Si le profil est déjà complété, on redirige ailleurs
            return redirect()->route('dashboard'); // Ou une autre page
        }

        return $next($request);
    }
}
