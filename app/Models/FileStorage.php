<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileStorage extends Model
{
    use HasFactory;

    public const TABLE = 'file_storages';
    public const FIELD_USER_ID = 'user_id';
    public const FIELD_ORIGINAL_NAME = 'original_name';
    public const FIELD_NAME = 'name';
    public const FIELD_PATH = 'path';
    public const FIELD_FORMAT = 'format';
    public const FIELD_MIME_TYPE = 'mime_type';
    public const FIELD_SIZE = 'size';
    public const FIELD_GROUP = 'group';

    protected $fillable = [
        self::FIELD_USER_ID,
        self::FIELD_ORIGINAL_NAME,
        self::FIELD_NAME,
        self::FIELD_PATH,
        self::FIELD_FORMAT,
        self::FIELD_MIME_TYPE,
        self::FIELD_SIZE,
        self::FIELD_GROUP,
    ];
}
