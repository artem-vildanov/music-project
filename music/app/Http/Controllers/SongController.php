<?php

namespace App\Http\Controllers;

use App\Http\Requests\Song\CreateSongRequest;
use App\Mappers\SongMapper;
use App\Repository\AlbumRepositoryInterface;
use App\Repository\ArtistRepositoryInterface;
use App\Repository\SongRepositoryInterface;
use App\Services\SongService;
use Illuminate\Http\JsonResponse;

class SongController extends Controller
{


    public function __construct(
        private readonly AlbumRepositoryInterface $albumRepository,
        private readonly ArtistRepositoryInterface $artistRepository,
        private readonly SongRepositoryInterface $songRepository,
        private readonly SongService $songService,
        private readonly SongMapper $songMapper,
    ) {
    }

    public function show(int $songId): JsonResponse
    {
        $song = $this->songRepository->getById($songId);
        $songDto = $this->songMapper->map($song);

        return response()->json($songDto);
    }

    public function create(CreateSongRequest $request, int $albumId): JsonResponse
    {
        $data = $request->body();


        // TODO authorship verification
//        $artistId = $this->albumRepository->getById($data['albumId'])->artist_id;
//        $userId = $this->artistRepository->getById($artistId)->user_id;
//
//        if ($userId !== auth()->id())
//            return response()->json([
//                'error' => 'You are not permitted to access this resource.',
//            ], 403);
        // TODO authorship verification

        $songId = $this->songService->saveSong($data->name, $data->music, $albumId);

        return response()->json([
            'songId' => $songId,
            'message' => 'song created successfully'
        ]);
    }
}
