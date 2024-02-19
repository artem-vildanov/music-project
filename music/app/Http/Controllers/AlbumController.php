<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\AlbumDto;
use App\DataTransferObjects\SongDto;
use App\Http\Requests\Album\CreateAlbumRequest;
use App\Http\Requests\Album\UpdateAlbumRequest;
use App\Mappers\AlbumMapper;
use App\Mappers\SongMapper;
use App\Repository\Interfaces\AlbumRepositoryInterface;
use App\Repository\Interfaces\ArtistRepositoryInterface;
use App\Repository\Interfaces\GenreRepositoryInterface;
use App\Repository\Interfaces\SongRepositoryInterface;
use App\Services\AlbumService;
use Illuminate\Http\JsonResponse;

class AlbumController extends Controller
{
    public function __construct(
        private readonly AlbumRepositoryInterface $albumRepository,
        private readonly SongRepositoryInterface $songRepository,
        private readonly ArtistRepositoryInterface $artistRepository,
        private readonly GenreRepositoryInterface $genreRepository,
        private readonly AlbumService $albumService,
        private readonly SongMapper $songMapper,
    ) {}

    public function show(int $albumId): JsonResponse
    {
        $album = $this->albumRepository->getById($albumId);
        $albumDto = AlbumDto::mapAlbum($album);

        $artist = $this->artistRepository->getById($album->artist_id);
        $albumDto->artistName = $artist->name;

        $genre = $this->genreRepository->getById($album->genre_id);
        $albumDto->genreName = $genre->name;

        $songs = $this->songRepository->getAllByAlbum($album->id);
        $albumDto->songs = SongDto::mapSongsArray($songs);
        foreach ($albumDto->songs as $song) {
            $song->artistName = $artist->name;
        }

        return response()->json($albumDto);
    }


    // for artist role
    public function create(CreateAlbumRequest $request): JsonResponse
    {
        $data = $request->body();

        $albumId = $this->albumService->saveAlbum(
            $data->name,
            $data->photo,
            $data->genreId
        );

        if ($albumId) {
            return response()->json([
                'albumId' => $albumId,
                'message' => 'album created successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'failed to create album',
            ], 400);
        }
    }

    public function update(int $albumId, UpdateAlbumRequest $request): JsonResponse
    {
        $data = $request->body();

        if ($this->albumService->updateAlbum(
            $albumId,
            $data->name,
            $data->photo,
            $data->status,
            $data->genreId
        )) {
            return response()->json([
                'albumId' => $albumId,
                'message' => 'album updated successfully'
            ]);
        } else {
            return response()->json([
                'albumId' => $albumId,
                'message' => 'failed to update album'
            ], 400);
        }
    }

    public function delete(int $albumId): JsonResponse
    {
        if ($this->albumService->deleteAlbum($albumId)) {
            return response()->json([
                'albumId' => $albumId,
                'message' => 'album deleted successfully'
            ]);
        } else {
            return response()->json([
                'albumId' => $albumId,
                'message' => 'failed to delete album'
            ], 400);
        }
    }
}
