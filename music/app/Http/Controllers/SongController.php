<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\SongDto;
use App\Http\Requests\Song\CreateSongRequest;
use App\Http\Requests\Song\UpdateSongRequest;
use App\Mappers\SongMapper;
use App\Repository\Interfaces\ArtistRepositoryInterface;
use App\Repository\Interfaces\SongRepositoryInterface;
use App\Services\SongService;
use Illuminate\Http\JsonResponse;

class SongController extends Controller
{


    public function __construct(
        private readonly SongRepositoryInterface $songRepository,
        private readonly ArtistRepositoryInterface $artistRepository,
        private readonly SongService $songService,
        private readonly SongMapper $songMapper,
    ) {
    }

    public function show(int $artistId, int $songId): JsonResponse
    {
        $song = $this->songRepository->getById($songId);
        $songDto = SongDto::mapSong($song);

        $artist = $this->artistRepository->getById($artistId);
        $songDto->artistName = $artist->name;

        return response()->json($songDto);
    }

    public function create(CreateSongRequest $request, int $albumId): JsonResponse
    {
        $data = $request->body();

        $songId = $this->songService->saveSong($data->name, $data->music, $albumId);

        return response()->json([
            'songId' => $songId,
            'message' => 'song created successfully'
        ]);
    }

    public function update(int $albumId, int $songId, UpdateSongRequest $request): JsonResponse
    {
        $data = $request->body();

        if($this->songService->updateSong($songId, $data->name, $data->music)) {
            return response()->json([
                'songId' => $songId,
                'message' => 'song updated successfully'
            ]);
        } else {
            return response()->json([
                'songId' => $songId,
                'message' => 'failed to update song'
            ], 400);
        }
    }

    public function delete(int $albumId, int $songId): JsonResponse
    {
        if ($this->songService->deleteSong($songId)) {
            return response()->json([
                'songId' => $songId,
                'message' => 'song deleted successfully'
            ]);
        } else {
            return response()->json([
                'songId' => $songId,
                'message' => 'failed to delete song'
            ], 400);
        }
    }
}
