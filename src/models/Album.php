<?php

class Album
{
    private $id;
    private $userId;
    private $albumTitle;
    private $authorName;
    private $language;
    private $releaseDate;
    private $category;
    private $numberOfSongs;
    private $description;

    public function __construct(?int $id, int $userId, string $albumTitle, string $authorName, string $language, string $releaseDate, string $category, int $numberOfSongs, string $description)
    {
        $this->id = $id;
        $this->userId = $$userId;
        $this->albumTitle = $albumTitle;
        $this->authorName = $authorName;
        $this->language = $language;
        $this->releaseDate = $releaseDate;
        $this->category = $category;
        $this->numberOfSongs = $numberOfSongs;
        $this->description = $description;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getAlbumTitle(): string
    {
        return $this->albumTitle;
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getNumberOfSongs(): int
    {
        return $this->numberOfSongs;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

}