<?php

namespace App\Http\Middleware;

use App\Repository\Interfaces\ArtistRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OwnershipVerification
{
    public function __construct(
        private readonly ArtistRepositoryInterface $artistRepository,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $requestArtistId = (int)$request->route('artistId');
        $artist = $this->artistRepository->getByUserId(auth()->id());

        if ($requestArtistId !== $artist->id) {
            return response()->json([
                'error' => 'You are not permitted to access this resource.',
            ], 403);
        }


        return $next($request);
    }
}
