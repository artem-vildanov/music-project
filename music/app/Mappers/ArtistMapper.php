<?php

namespace App\Mappers;

use App\DataTransferObjects\ArtistDto;
use App\Models\Artist;
use App\Repository\Interfaces\IAlbumRepository;
use App\Repository\Interfaces\IFavouritesRepository;

class ArtistMapper
{
    public function __construct(
        private readonly IFavouritesRepository $favouritesRepository
    ) {}

    /**
     * @param Artist[] $artists
     * @return ArtistDto[]
     */
    public function mapMultipleArtists(array $artists): array
    {
        $favouriteArtistsIdsGroup = $this->favouritesRepository->getFavouriteArtistsIds(auth()->id());
        $artistsDtoGroup = [];

        foreach($artists as $artist) {
            $artistDto = $this->map($artist);
            $artistDto->isFavourite = in_array($artistDto->id, $favouriteArtistsIdsGroup);
            $artistsDtoGroup[] = $artistDto;
        }

        return $artistsDtoGroup;
    }

    /**
     * @param Artist $artist
     * @return ArtistDto
     */
    public function mapSingleArtist(Artist $artist): ArtistDto
    {
        $artistDto = $this->map($artist);
        $artistDto->isFavourite = $this->favouritesRepository->checkArtistIsFavourite(auth()->id(), $artist->id);

        return $artistDto;
    }

    private function map(Artist $artist): ArtistDto
    {
        $artistDto = new ArtistDto();
        $artistDto->id = $artist->id;
        $artistDto->name = $artist->name;
        $artistDto->likes = $artist->likes;
        $artistDto->photoPath = $artist->photo_path;
        $artistDto->userId = $artist->user_id;

        return $artistDto;
    }
}
