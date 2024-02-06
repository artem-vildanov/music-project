<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\AlbumDto;
use App\DataTransferObjects\SongDto;
use App\Http\Requests\Album\CreateAlbumRequest;
use App\Repository\AlbumRepositoryInterface;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    private AlbumRepositoryInterface $albumRepository;

    public function __construct(AlbumRepositoryInterface $albumRepository)
    {
        $this->albumRepository = $albumRepository;
    }

    public function show($id) {
        $album = $this->albumRepository->getById($id);
        return response()->json($album);
    }


    // for artist role
    public function create(CreateAlbumRequest $request)
    {
        $data = $request->validated();

        //dd($data['songs']);



        $albumDto = new AlbumDto();
        $albumDto->name = $data['name'];
        $albumDto->photoPath = $data['photo']->store('albums_photos', 's3');
        foreach ($data['songs'] as $songData) {
            $songDto = new SongDto();

            // dd($songData['music']);

            $songDto->name = $songData['name'];
            $songDto->musicPath = $songData['music']->store('songs', 's3');

            $albumDto->songs[] = $songDto;
        }

        return response()->json($albumDto);
    }

    public function delete() {

    }

    public function update() {

    }
}
