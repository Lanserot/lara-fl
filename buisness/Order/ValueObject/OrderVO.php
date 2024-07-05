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
    private int $budget;
    private string $date;

    private function __construct(
        string $title,
        string $description,
        int $budget,
        string $date,
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->budget = $budget;
        $this->date = $date;
    }

    static function get(
        string $title,
        string $description,
        int $budget,
        string $date,
    ): OrderVO
    {
        return new self($title, $description, $budget, $date);
    }

    static function getNull(): OrderVO
    {
        return new self('', '', 0, '');
    }

    public function isNull(): bool
    {
        return $this->title == '' && $this->description == '' && $this->budget == 0 && $this->date == '';
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
}
