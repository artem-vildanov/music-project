<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\AlbumDto;
use App\DataTransferObjects\ArtistDto;
use App\Http\Requests\Artist\CreateArtistRequest;
use App\Http\Requests\Artist\UpdateArtistRequest;
use App\Mappers\AlbumMapper;
use App\Mappers\ArtistMapper;
use App\Repository\Interfaces\AlbumRepositoryInterface;
use App\Repository\Interfaces\ArtistRepositoryInterface;
use App\Services\ArtistService;
use Illuminate\Http\JsonResponse;

class ArtistController extends Controller
{
    public function __construct(
        private readonly ArtistService $artistService,
        private readonly ArtistRepositoryInterface $artistRepository,
        private readonly AlbumRepositoryInterface $albumRepository,
    ) {}

    public function show(int $artistId): JsonResponse
    {
        $artist = $this->artistRepository->getById($artistId);
        $artistDto = ArtistDto::mapArtist($artist);

        $albums = $this->albumRepository->getAllByArtist($artistDto->id);
        $artistDto->albums = AlbumDto::mapAlbumsArray($albums);

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

    public function update(int $artistId, UpdateArtistRequest $request): JsonResponse
    {
        $data = $request->body();

        if ($this->artistService->updateArtist(
            $artistId,
            $data->name,
            $data->photo
        )) {
            return response()->json([
                'artistId' => $artistId,
                'message' => 'artist updated successfully'
            ]);
        } else {
            return response()->json([
                'artistId' => $artistId,
                'message' => 'failed to update artist'
            ], 400);
        }
    }

    public function delete(int $artistId): JsonResponse
    {
        if ($this->artistService->deleteArtist($artistId)) {
            return response()->json([
                'artistId' => $artistId,
                'message' => 'artist deleted successfully'
            ]);
        } else {
            return response()->json([
                'artistId' => $artistId,
                'message' => 'failed to delete artist'
            ], 400);
        }
    }
}
