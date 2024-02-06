<?php

namespace App\Http\Controllers;

use App\Repository\ArtistRepositoryInterface;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    private ArtistRepositoryInterface $artistRepository;

    public function __construct(ArtistRepositoryInterface $artistRepository)
    {

        $this->artistRepository = $artistRepository;
    }

    public function show($id)
    {
        $artist = $this->artistRepository->getById($id);
        return response()->json($artist);
    }
}
