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
    private int $category_id;

    private function __construct(
        string $title,
        string $description,
        int $category,
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->category_id = $category;
    }

    static function get(
        string $title,
        string $description,
        int $category
    ): OrderVO
    {
        return new self($title, $description, $category);
    }

    static function getNull(): OrderVO
    {
        return new self('', '', 0);
    }

    public function isNull(): bool
    {
        return $this->title == '' && $this->description == '' && $this->category_id == 0;
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

    public function getCategoryId(): int
    {
        return $this->category_id;
    }
}
