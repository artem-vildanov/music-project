<?php

namespace App\Http\Middleware;

use App\Repository\AlbumRepositoryInterface;
use App\Repository\ArtistRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlbumOwnershipVerification
{
    public function __construct(
        private readonly AlbumRepositoryInterface $albumRepository,
        private readonly ArtistRepositoryInterface $artistRepository,
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        $albumId = $request->route('albumId');
        $artistId = $this->albumRepository->getById($albumId)->artist_id;
        $userId = $this->artistRepository->getById($artistId)->user_id;

        if ($userId !== auth()->id())
            return response()->json([
                'error' => 'You are not permitted to access this resource.',
            ], 403);

        return $next($request);
    }
}
