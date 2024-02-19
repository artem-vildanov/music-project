<?php

namespace App\Http\Middleware;

use App\Repository\Interfaces\AlbumRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAlbumExists
{
    public function __construct(
        private readonly AlbumRepositoryInterface $albumRepository
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $albumId = (int)$request->route('albumId');
        $artistId = (int)$request->route('artistId');

        $album = $this->albumRepository->getById($albumId);

        if (!$album) {
            return response()->json([
                'message' => 'album with such id does not exist'
            ], 400);
        }

        if ($album->artist_id !== $artistId) {
            return response()->json([
                'albumId' => $albumId,
                'artistId' => $artistId,
                'message' => 'artist does not have that album'
            ], 400);
        }

        return $next($request);
    }
}
