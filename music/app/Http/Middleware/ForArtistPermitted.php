<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForArtistPermitted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->role !== 'artist')
        {
            return response()->json([
                'error' => 'You are not permitted to access this resource.',
            ], 403);
        }
        return $next($request);
    }
}
