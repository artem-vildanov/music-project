<?php

namespace App\Http\Controllers;

use App\Http\Requests\Artist\CreateArtistRequest;
use App\Mappers\AlbumMapper;
use App\Mappers\ArtistMapper;
use App\Repository\AlbumRepositoryInterface;
use App\Repository\ArtistRepositoryInterface;
use App\Services\ArtistService;
use Illuminate\Http\JsonResponse;

class ArtistController extends Controller
{
    public function __construct(
        private readonly ArtistService $artistService,
        private readonly ArtistMapper $artistMapper,
        private readonly AlbumMapper $albumMapper,
        private readonly ArtistRepositoryInterface $artistRepository,
        private readonly AlbumRepositoryInterface $albumRepository,
    ) {}

    public function show(int $artistId): JsonResponse
    {
        $artist = $this->artistRepository->getById($artistId);
        $artistDto = $this->artistMapper->map($artist);

        $albums = $this->albumRepository->getAllByArtist($artistDto->id);
        $artistDto->albums = $this->albumMapper->mapMultiple($albums);

        return response()->json($artistDto);
    }

    // only for base_user role
    public function create(CreateArtistRequest $request): JsonResponse
    {
        $data = $request->body();

        $artistId = $this->artistService->saveArtist($data->name, $data->photo);

        return response()->json([
            'artistId' => $artistId,
            'message' => 'new artist created successfully',
        ]);
    }
}
