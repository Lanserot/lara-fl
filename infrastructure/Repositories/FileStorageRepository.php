<?php

declare(strict_types=1);

namespace Infrastructure\Repositories;

use App\Models\FileStorage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Infrastructure\Interfaces\IFileStorageRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileStorageRepository implements IFileStorageRepository
{
    public function save(UploadedFile $file): bool
    {
        $user_id = auth()->user()->getAuthIdentifier();
        $fileExtension = $file->getClientOriginalExtension();
        $newFileName = time() . '-' . $user_id . '-' . Str::random(16) . '.' . $fileExtension;
        $path = 'uploads\\' . $user_id . '\\avatar';

        DB::beginTransaction();
        try {
            $file_storage = FileStorage::create([
                FileStorage::FIELD_USER_ID          => $user_id,
                FileStorage::FIELD_ORIGINAL_NAME    => $file->getClientOriginalName(),
                FileStorage::FIELD_NAME             => $newFileName,
                FileStorage::FIELD_PATH             => $path,
                FileStorage::FIELD_FORMAT           => $fileExtension,
                FileStorage::FIELD_MIME_TYPE        => $file->getMimeType(),
                FileStorage::FIELD_SIZE             => $file->getSize(),
                FileStorage::FIELD_GROUP             => 1,
            ]);
            $this->last_id = $file_storage->id;
            $file->move($path, $newFileName);
            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return false;
        }

        return true;
    }
}
