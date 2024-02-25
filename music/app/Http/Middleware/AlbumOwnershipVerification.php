<?php

namespace App\Http\Middleware;

use App\Repository\Interfaces\IAlbumRepository;
use App\Repository\Interfaces\IArtistRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlbumOwnershipVerification
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

        $userId = $this->artistRepository->getById($album->artist_id)->user_id;

        if ($userId !== auth()->id()) {
            return response()->json([
                'error' => 'You are not permitted to access this resource.',
            ], 403);
        }


        return $next($request);
    }
}
