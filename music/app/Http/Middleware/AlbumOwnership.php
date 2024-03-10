<?php

namespace App\Http\Middleware;

use App\Exceptions\DataAccessExceptions\DataAccessException;
use App\Facades\AuthFacade;
use App\Repository\Interfaces\IAlbumRepository;
use App\Repository\Interfaces\IArtistRepository;
use App\Services\AlbumService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlbumOwnership
{
    public function __construct(
        private readonly AlbumService $albumService
    ) {}

    /**
     * @throws DataAccessException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestAlbumId = (int)$request->route('albumId');

        $album = $this->albumService->getAlbum($requestAlbumId);

        $authUser = AuthFacade::getAuthInfo();

        if ($album->artist_id !== $authUser->artistId) {
            return response()->json([
                'error' => 'You are not permitted to access this resource.',
            ], 403);
        }


        return $next($request);
    }
}
