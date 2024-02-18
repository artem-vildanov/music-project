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

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        $albumId = $request->route('albumId');

        $album = $this->albumRepository->getById($albumId);

        if (!$album) {
            return response()->json([
                'message' => 'album with such id does not exist'
            ], 400);
        }

        return $next($request);
    }
}
