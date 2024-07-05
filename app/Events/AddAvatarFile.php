<?php

namespace App\Events;

class AddAvatarFile
{
    public int $file_id;

    public function __construct(int $file_id)
    {
        $this->file_id = $file_id;
    }

    public function getFileId(): int
    {
        return $this->file_id;
    }

}
