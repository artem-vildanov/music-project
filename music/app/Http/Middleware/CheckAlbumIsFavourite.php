<?php

namespace App\Http\Middleware;

use App\Repository\Interfaces\IFavouritesRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAlbumIsFavourite
{
    public function __construct(
        private readonly IFavouritesRepository $favouritesRepository
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $albumId = $request->route('albumId');
        $userId = auth()->id();

        if (!$this->favouritesRepository->checkAlbumIsFavourite($userId, $albumId)) {
            return response()->json([
                'message' => 'failed to add album to favourites'
            ]);
        }

        return $next($request);
    }
}
