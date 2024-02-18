<?php

declare(strict_types=1);

namespace App\Services;

use Aws\S3\S3Client;
use Illuminate\Http\UploadedFile;

class PhotoStorageService
{
    public function saveAlbumPhoto(UploadedFile $file): string|null
    {
        $fileName = uniqid(more_entropy: true);
        $filePath = "album/{$fileName}.png";

        return $this->storePhoto($filePath, $file);
    }

    public function saveArtistPhoto(UploadedFile $file): string|null
    {
        $fileName = uniqid(more_entropy: true);
        $filePath = "artist/{$fileName}.png";

        return $this->storePhoto($filePath, $file);
    }

    public function updatePhoto(string $filePath, UploadedFile $file): bool
    {
        return (bool)$this->storePhoto($filePath, $file);
    }

    public function deletePhoto(string $filePath): bool
    {
        $result = $this->getClient()->deleteObject([
            'Bucket' => 'photo',
            'Key' => $filePath,
        ]);

        $statusCode = $result['@metadata']['statusCode'];

        return $statusCode === 204;
    }

    private function storePhoto(string $filePath, UploadedFile $file): string|null
    {
        $result = $this->getClient()->putObject(
            [
                'Bucket' => 'photo',
                'Key' => $filePath,
                'Body' => $file->getContent(),
            ]
        );

        $statusCode = $result['@metadata']['statusCode'];

        // $this->getClient()->waitUntil('ObjectExists', ['Bucket' => 'photo', 'Key' => $filePath]);



        return $statusCode === 200 ? $filePath : null;
    }

    private function getClient(): S3Client
    {
        return new S3Client(config('aws'));
    }

}
