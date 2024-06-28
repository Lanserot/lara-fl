<?php

declare(strict_types=1);

namespace Buisness\Order\ValueObject;

/**
 * Class OrderVO
 * @package Buisness\Order\ValueObject
 */
class OrderVO
{
    private string $title;
    private string $description;

    private function __construct(
        string $title,
        string $description,
    )
    {
        $this->title = $title;
        $this->description = $description;
    }

    static function get(
        string $title,
        string $description
    ): OrderVO
    {
        return new self($title, $description);
    }

    static function getNull(): OrderVO
    {
        return new self('', '');
    }

    public function isNull(): bool
    {
        return $this->title == '' && $this->description == '';
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
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
