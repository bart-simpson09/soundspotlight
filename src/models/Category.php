<?php

class Category
{
    private $id;
    private $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getCategoryName(): string
    {
        return $this->name;
    }

    public function getCategoryId(): int
    {
        return $this->id;
    }
}