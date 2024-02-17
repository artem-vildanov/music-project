<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForBaseUserPermitted
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->role !== 'base_user')
        {
            return response()->json([
                'error' => 'You are already have artist account.',
            ], 403);
        }

        return $next($request);
    }
}
