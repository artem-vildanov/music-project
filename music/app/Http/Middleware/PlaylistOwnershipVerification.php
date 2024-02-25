<?php

namespace App\Http\Middleware;

use App\Exceptions\DataAccessExceptions\DataAccessException;
use App\Repository\Interfaces\IPlaylistRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlaylistOwnershipVerification
{
    public function __construct(
        private readonly IPlaylistRepository $playlistRepository
    ) {}

    /**
     * @throws DataAccessException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $playlistId = $request->route('playlistId');
        $playlist = $this->playlistRepository->getById($playlistId);

        if ($playlist->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'not permitted to access this resource'
            ], 403);
        }

        return $next($request);
    }
}
