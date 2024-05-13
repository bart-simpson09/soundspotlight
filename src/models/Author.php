<?php

class Author
{
    private $id;
    private $name;

    public function __construct(?int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getAuthorId(): int
    {
        return $this->id;
    }

    public function getAuthorName(): string
    {
        return $this->name;
    }
}