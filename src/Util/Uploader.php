<?php

namespace App\Util;

use App\Entity\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader
{
    const BASE_PATH = '%s/%s/';

    public function upload(?UploadedFile $uploadedFile, ?Media $media, string $type, string $directory): ?Media
    {
        if (null === $uploadedFile) {
            return null;
        }

        FileSystem::createDirectoryIfDontExist(sprintf(self::BASE_PATH, $type, $directory));

        $extension = $uploadedFile->guessExtension();

        $size = $uploadedFile->getSize();

        $name = sprintf('%s.%s', md5(uniqid()), $extension);

        $uploadedFile->move(sprintf(self::BASE_PATH, $type, $directory), $name);

        if ($media instanceof Media) {
            FileSystem::delete($media->getPath(), $media->getName());
            return $media->load(sprintf(self::BASE_PATH, $type, $directory), $name, $extension, $directory, $size);
        }

        return (new Media())->load(sprintf(self::BASE_PATH, $type, $directory), $name, $extension, $directory, $size);
    }
}