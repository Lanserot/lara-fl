<?php

declare(strict_types=1);

namespace Buisness\File;

use Buisness\File\Security\CanAddFileCommand;
use Illuminate\Http\JsonResponse;
use Infrastructure\Interfaces\IFileStorageRepository;
use Infrastructure\Tools\JsonFormatter;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AddFileStorageCommand
 * @package Buisness\File
 */
class AddFileStorageCommand
{
    private UploadedFile $file;

    public function execute(): JsonResponse
    {
        if (!(new CanAddFileCommand())->execute()) {
            return JsonFormatter::makeAnswer(Response::HTTP_FORBIDDEN);
        }
        if($validate_resul = $this->validateFile()){
            return $validate_resul;
        }
        /** @var IFileStorageRepository $order_repository */
        $order_repository = app(IFileStorageRepository::class);
        $result = $order_repository->save($this->file);
        if ($result) {
            return JsonFormatter::makeAnswer(Response::HTTP_OK);
        }
        return JsonFormatter::makeAnswer(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    private function validateFile(): ?JsonResponse
    {
        if($this->file->getSize() > config('files.avatars.size')){
            return JsonFormatter::makeAnswer(Response::HTTP_REQUEST_ENTITY_TOO_LARGE, (string)$this->file->getSize());
        }
        if(!in_array($this->file->getClientOriginalExtension(), config('files.avatars.format'))){
            return JsonFormatter::makeAnswer(Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
        }
        return null;
    }

    public function setFileVO(UploadedFile $file): self
    {
        $this->file = $file;
        return $this;
    }
}
