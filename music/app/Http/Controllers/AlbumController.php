<?php

namespace App\Http\Controllers;

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
    public function create() {

    }

    public function delete() {

    }

    public function update() {

    }
}
