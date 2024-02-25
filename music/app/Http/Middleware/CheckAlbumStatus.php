<?php

namespace App\Http\Middleware;

use App\Repository\Interfaces\IAlbumRepository;
use App\Repository\Interfaces\IArtistRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAlbumStatus
{
    public function __construct(
        private readonly IAlbumRepository  $albumRepository,
        private readonly IArtistRepository $artistRepository,
    ) {}


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $albumId = $request->route('albumId');
        $album = $this->albumRepository->getById($albumId);
        $artist = $this->artistRepository->getById($album->artist_id);

        if (
            $artist->user_id !== auth()->id() and
            $album->status === 'private'
        ) {
            return response()->json([
                'error' => 'You are not permitted to access this resource.',
            ], 403);
        }

        return $next($request);
    }
}
