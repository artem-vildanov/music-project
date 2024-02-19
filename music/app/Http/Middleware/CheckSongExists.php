<?php

namespace App\Http\Middleware;

use App\Repository\Interfaces\SongRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSongExists
{
    public function __construct(
        private readonly SongRepositoryInterface $songRepository
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $songId = (int)$request->route('songId');
        $albumId = (int)$request->route('albumId');

        $song = $this->songRepository->getById($songId);

        if (!$song) {
            return response()->json([
                'songId' => $songId,
                'message' => 'such song does not exist',
            ], 400);
        }

        if ($song->album_id !== $albumId) {
            return response()->json([
                'songId' => $songId,
                'albumId' => $albumId,
                'message' => 'there is no such song in that album'
            ]);
        }

        return $next($request);
    }
}
