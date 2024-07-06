<?php

declare(strict_types=1);

namespace Buisness\Category\ValueObject;

/**
 * Class CategoryVO
 * @package Buisness\Category\ValueObject
 */
class CategoryVO
{
    private string $name;
    private string $name_rus;

    private function __construct(
        string $name,
        string $name_rus,
    )
    {
        $this->name = $name;
        $this->name_rus = $name_rus;
    }

    static function get(
        string $name,
        string $name_rus,
    ): CategoryVO
    {
        return new self($name, $name_rus);
    }

    static function getNull(): CategoryVO
    {
        return new self('', '');
    }

    public function isNull(): bool
    {
        return $this->name == '' && $this->name_rus == '';
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNameRus(): string
    {
        return $this->name_rus;
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
