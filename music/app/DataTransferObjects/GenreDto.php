<?php

namespace App\DataTransferObjects;

use App\Models\Genre;

class GenreDto
{
    public int $id;
    public string $name;
    public int $likes;

    public static function mapGenresArray(array $genres): array
    {
        $genreDtoCollection = [];
        foreach ($genres as $genre) {
            $genreDtoCollection[] = GenreDto::mapGenre($genre);
        }

        return $genreDtoCollection;
    }

    public static function mapGenre(Genre $genre): GenreDto
    {
        $genreDto = new GenreDto();
        $genreDto->id = $genre->id;
        $genreDto->name = $genre->name;
        $genreDto->likes = $genre->likes;

        return $genreDto;
    }
}
