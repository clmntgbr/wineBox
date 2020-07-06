<?php

namespace App\Entity\Wine;

use App\Entity\User\User;
use App\Repository\Wine\WineRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class AbstractWine
{
    abstract public function __toString(): string;
    abstract public function isCreator(User $user): bool;
    abstract public function addPopularity(): void;
    abstract public function removePopularity(): void;
}
