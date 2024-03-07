<?php

namespace App\Http\Middleware;

use App\Facades\AuthFacade;
use App\Repository\Interfaces\IAlbumRepository;
use App\Repository\Interfaces\IArtistRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAlbumStatus
{
    public function __construct(
        private readonly IAlbumRepository  $albumRepository,
    ) {}


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $albumId = $request->route('albumId');

        // TODO сначала запрос к кэшу, затем запрос к бд если нет в кэше
        $album = $this->albumRepository->getById($albumId);

        $authUser = AuthFacade::getAuthInfo();

        if (
            $album->artist_id !== $authUser->artistId &&
            $album->status === 'private'
        ) {
            return response()->json([
                'error' => 'You are not permitted to access this resource.',
            ], 403);
        }

        return $next($request);
    }
}
