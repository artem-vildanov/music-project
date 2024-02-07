<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\AlbumDto;
use App\DataTransferObjects\SongDto;
use App\Http\Requests\Album\CreateAlbumRequest;
use App\Repository\AlbumRepositoryInterface;
use App\Repository\ArtistRepositoryInterface;

class AlbumController extends Controller
{
    private AlbumRepositoryInterface $albumRepository;
    private ArtistRepositoryInterface $artistRepository;

    public function __construct(AlbumRepositoryInterface $albumRepository,
                                ArtistRepositoryInterface $artistRepository,
    ) {
        $this->albumRepository = $albumRepository;
        $this->artistRepository = $artistRepository;
    }

    public function show($id) {
        $album = $this->albumRepository->getById($id);
        return response()->json($album);
    }


    // for artist role
    public function create(CreateAlbumRequest $request)
    {
        $data = $request->validated();

        $albumDto = new AlbumDto();
        $albumDto->name = $data['name'];
        $albumDto->likes = 0;
        $albumDto->photo = $data['photo'];

        $artist = $this->artistRepository->getByUserId(auth()->id());

        if ($artist)
            $albumDto->artistId = $artist->id;
        else
            return response()->json([
                'error' => 'You are not permitted to access this resource.',
            ], 403);

        foreach ($data['songs'] as $songData) {
            $songDto = new SongDto();
            $songDto->name = $songData['name'];
            $songDto->likes = 0;
            $songDto->music = $songData['music'];
            $albumDto->songs[] = $songDto;
        }

        $this->albumRepository->create($albumDto);


        return response()->json($createdAlbumId);
    }

    public function delete() {

    }

    public function update() {

    }
}
