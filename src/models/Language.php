<?php

class Language
{
    private $id;
    private $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getLanguageId(): int
    {
        return $this->id;
    }

    public function getLanguageName(): string
    {
        return $this->name;
    }
}