<?php

declare(strict_types=1);

namespace Buisness\File\ValueObject;

/**
 * Class OrderVO
 * @package Buisness\Order\ValueObject
 */
class FileVO
{
    private int $user_id;
    private string $original_name;
    private string $name;
    private string $path;
    private string $format;
    private string $mime_type;
    private int $size;

    private function __construct(
        int    $user_id,
        string $original_name,
        string $name,
        string $path,
        string $format,
        string $mime_type,
        int    $size
    )
    {
        $this->user_id = $user_id;
        $this->original_name = $original_name;
        $this->name = $name;
        $this->path = $path;
        $this->format = $format;
        $this->mime_type = $mime_type;
        $this->size = $size;
    }

    static function get(
        int    $user_id,
        string $original_name,
        string $name,
        string $path,
        string $format,
        string $mime_type,
        int    $size
    ): FileVO
    {
        return new self(
            $user_id,
            $original_name,
            $name,
            $path,
            $format,
            $mime_type,
            $size
        );
    }

    static function getNull(): FileVO
    {
        return new self(0, '', '', '', '', '', 0);
    }

    public function isNull(): bool
    {
        return
            $this->user_id == ''
            && $this->original_name == ''
            && $this->name == ''
            && $this->path == ''
            && $this->format == ''
            && $this->mime_type == ''
            && $this->size == 0;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getOriginalName(): string
    {
        return $this->original_name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function getMimeType(): string
    {
        return $this->mime_type;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function toArray(): array
    {
        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties();
        $array = [];
        foreach ($properties as $property) {
            $array[$property->getName()] = $property->getValue($this);
        }

        return $array;
    }
}
