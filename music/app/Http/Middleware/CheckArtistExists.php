<?php

namespace App\Http\Middleware;

use App\Repository\Interfaces\AlbumRepositoryInterface;
use App\Repository\Interfaces\ArtistRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckArtistExists
{
    public function __construct(
        private readonly ArtistRepositoryInterface $artistRepository
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $artistId = (int)$request->route('artistId');

        $artist = $this->artistRepository->getById($artistId);

        if (!$artist) {
            return response()->json([
                'artistId' => $artistId,
                'message' => 'such artist does not exist',
            ], 400);
        }

        return $next($request);
    }


}
