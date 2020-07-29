<?php

namespace App\Entity\Wine;

use App\Entity\User\User;

abstract class AbstractWine
{
    abstract public function __toString(): string;
    abstract public function isCreator(User $user): bool;
    abstract public function addPopularity(): void;
    abstract public function removePopularity(): void;
    abstract public function hasUploadedFile(): bool;
}
