<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ArtistDto;
use App\Http\Requests\Artist\CreateArtistRequest;
use App\Repository\ArtistRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Aws\Credentials\Credentials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;

class ArtistController extends Controller
{
    private ArtistRepositoryInterface $artistRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        ArtistRepositoryInterface $artistRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->artistRepository = $artistRepository;
        $this->userRepository = $userRepository;
    }

    public function show($id)
    {
        $artist = $this->artistRepository->getById($id);
        return response()->json($artist);
    }

    public function create(CreateArtistRequest $request)
    {
        $data = $request->validated();

        $artistDto = new ArtistDto();
        $artistDto->name = $data['name'];
        $artistDto->likes = 0;
        $artistDto->photoPath = $request->file('photo')->store('artists_photos', 's3');
        $artistDto->userId = auth()->id();

        $artistDto->id = $this->artistRepository->create($artistDto);
        $this->userRepository->roleArtist($artistDto->userId);

        return response()->json($artistDto);
    }

    public function test() {
        return response()->json([
            'status' => 'succeed'
        ]);
    }
}
