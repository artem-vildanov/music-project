<?php

namespace App\Http\Controllers;

use App\Exceptions\DataAccessExceptions\DataAccessException;
use App\Mappers\AlbumMapper;
use App\Mappers\GenreMapper;
use App\Repository\Interfaces\IAlbumRepository;
use App\Repository\Interfaces\IGenreRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function __construct(
        private readonly IGenreRepository $genreRepository,
        private readonly IAlbumRepository $albumRepository,
        private readonly GenreMapper $genreMapper,
        private readonly AlbumMapper $albumMapper,
    ) {}

    public function show(int $genreId): JsonResponse
    {
        $genre = $this->genreRepository->getById($genreId);
        $genreDto = $this->genreMapper->mapSingleGenre($genre);

        return response()->json($genreDto);
    }

    public function showAll(): JsonResponse
    {
        $genresModelsGroup = $this->genreRepository->getAll();
        $genresDtoGroup = $this->genreMapper->mapMultipleGenres($genresModelsGroup);

        return response()->json($genresDtoGroup);
    }

    /**
     * @throws DataAccessException
     */
    public function albumsWithGenre(int $genreId): JsonResponse
    {
        $albumsModelsGroup = $this->albumRepository->getAllByGenre($genreId);
        $albumsDtoGroup = $this->albumMapper->mapMultipleAlbums($albumsModelsGroup);

        return response()->json($albumsDtoGroup);
    }
}
