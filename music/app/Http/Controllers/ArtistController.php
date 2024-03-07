<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\AlbumDto;
use App\DataTransferObjects\ArtistDto;
use App\Exceptions\DataAccessExceptions\DataAccessException;
use App\Exceptions\JwtException;
use App\Exceptions\MinioException;
use App\Http\Requests\Artist\CreateArtistRequest;
use App\Http\Requests\Artist\UpdateArtistRequest;
use App\Mappers\AlbumMapper;
use App\Mappers\ArtistMapper;
use App\Repository\Interfaces\IAlbumRepository;
use App\Repository\Interfaces\IArtistRepository;
use App\Repository\Interfaces\IGenreRepository;
use App\Services\ArtistService;
use App\Services\TokenService;
use App\Services\EncodeDecodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function __construct(
        private readonly ArtistService       $artistService,
        private readonly IArtistRepository   $artistRepository,
        private readonly IAlbumRepository    $albumRepository,
        private readonly TokenService        $authService,
        private readonly EncodeDecodeService $jwtService,
        private readonly ArtistMapper        $artistMapper,
        private readonly AlbumMapper         $albumMapper
    ) {}

    /**
     * @throws DataAccessException
     */
    public function show(int $artistId): JsonResponse
    {
        $artist = $this->artistRepository->getById($artistId);
        $artistDto = $this->artistMapper->mapSingleArtist($artist);

        return response()->json($artistDto);
    }

    public function showAlbumsMadeByArtist(int $artistId): JsonResponse
    {
        $albumsMadeByArtist = $this->albumRepository->getAllByArtist($artistId);
        $albumsDtoGroup = $this->albumMapper->mapMultipleAlbums($albumsMadeByArtist);

        return response()->json($albumsDtoGroup);
    }

    /**
     * @throws DataAccessException
     * @throws MinioException
     * @throws JwtException
     */
    public function create(CreateArtistRequest $request): JsonResponse
    {
        $data = $request->body();

        $artistId = $this->artistService->saveArtist($data->name, $data->photo);

        $token = $this->jwtService->getTokenFromRequest($request);
        $newToken = $this->authService->refreshToken($token);

        return response()->json([
            'artistId' => $artistId,
            'message' => 'new artist created successfully, your access token has been refreshed',
            'token' => $newToken
        ]);
    }

    /**
     * @throws DataAccessException
     * @throws MinioException
     */
    public function update(int $artistId, UpdateArtistRequest $request): JsonResponse
    {
        $data = $request->body();

        $this->artistService->updateArtist(
            $artistId,
            $data->name,
            $data->photo
        );

        return response()->json();
    }

    /**
     * @throws DataAccessException
     * @throws MinioException
     * @throws JwtException
     */
    public function delete(int $artistId, Request $request): JsonResponse
    {
        $this->artistService->deleteArtist($artistId);

        $token = $this->jwtService->getTokenFromRequest($request);
        $newToken = $this->authService->refreshToken($token);

        return response()->json([
            'message' => 'artist deleted successfully, your token has been refreshed',
            'token' => $newToken
        ]);
    }
}
