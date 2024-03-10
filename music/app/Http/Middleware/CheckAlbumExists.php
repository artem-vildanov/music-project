<?php

namespace App\Http\Middleware;

use App\Exceptions\DataAccessExceptions\DataAccessException;
use App\Repository\Interfaces\IAlbumRepository;
use App\Services\AlbumService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAlbumExists
{
    public function __construct(
        private readonly AlbumService $albumService
    ) {}

    /**
     * @throws DataAccessException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $albumId = (int)$request->route('albumId');

        $album = $this->albumService->getAlbum($albumId);

        return $next($request);
    }
}
