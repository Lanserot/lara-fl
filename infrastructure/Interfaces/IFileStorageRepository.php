<?php

namespace Infrastructure\Interfaces;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface IFileStorageRepository
{
    public function save(UploadedFile $file): bool;
}
