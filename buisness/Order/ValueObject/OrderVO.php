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
    private string $created_at;
    private int $budget;
    private string $date;

    private function __construct(
        string $title,
        string $description,
        string $created_at,
        int $budget,
        string $date,
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->created_at = $created_at;
        $this->budget = $budget;
        $this->date = $date;
    }

    static function get(
        string $title,
        string $description,
        string $created_at,
        int $budget,
        string $date,
    ): OrderVO
    {
        return new self($title, $description, $created_at, $budget, $date);
    }

    static function getNull(): OrderVO
    {
        return new self('', '', '', 0, '');
    }

    public function isNull(): bool
    {
        return $this->title == '' && $this->description == '' && $this->budget == 0 && $this->date == '' && $this->created_at == '';
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getBudget(): int
    {
        return $this->budget;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
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
