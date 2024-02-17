<?php

namespace App\Http\Controllers;

use App\Http\Requests\Album\CreateAlbumRequest;
use App\Mappers\AlbumMapper;
use App\Mappers\SongMapper;
use App\Repository\AlbumRepositoryInterface;
use App\Repository\SongRepositoryInterface;
use App\Services\AlbumService;
use Illuminate\Http\JsonResponse;

class AlbumController extends Controller
{
    public function __construct(
        private readonly AlbumRepositoryInterface $albumRepository,
        private readonly SongRepositoryInterface $songRepository,
        private readonly AlbumService $albumService,
        private readonly AlbumMapper $albumMapper,
        private readonly SongMapper $songMapper,
    ) {}

    public function show(int $albumId): JsonResponse
    {
        $album = $this->albumRepository->getById($albumId);
        // dd($album);
        $albumDto = $this->albumMapper->map($album);

        $songs = $this->songRepository->getAllByAlbum($album->id);
        $albumDto->songs = $this->songMapper->mapMultiple($songs);

        return response()->json($albumDto);
    }


    // for artist role
    public function create(CreateAlbumRequest $request): JsonResponse
    {
        $data = $request->body();

        $albumId = $this->albumService->saveAlbum($data->name, $data->photo);

        if (!$albumId)
            return response()->json([
                'message' => 'failed to create album',
            ]);

        return response()->json([
            'albumId' => $albumId,
            'message' => 'album created successfully',
        ]);
    }

    public function delete() {

    }

    public function update() {

    }
}
