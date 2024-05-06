<?php

class Album
{
    private $id;
    private $albumTitle;
    private $authorId;
    private $languageId;
    private $categoryId;
    private $numberOfSongs;
    private $description;
    private $averageRate;
    private $cover;
    private $releaseDate;
    private $uploadDate;
    private $approveDate;
    private $declineDate;
    private $addedBy;

    public function __construct(int $id, string $albumTitle, int $authorId, int $languageId, int $categoryId, int $numberOfSongs, string $description, float $averageRate, string $cover, string $releaseDate, string $uploadDate, string $approveDate, string $declineDate, int $addedBy)
    {
        $this->id = $id;
        $this->albumTitle = $albumTitle;
        $this->authorId = $authorId;
        $this->languageId = $languageId;
        $this->categoryId = $categoryId;
        $this->numberOfSongs = $numberOfSongs;
        $this->description = $description;
        $this->averageRate = $averageRate;
        $this->cover = $cover;
        $this->releaseDate = $releaseDate;
        $this->uploadDate = $uploadDate;
        $this->approveDate = $approveDate;
        $this->declineDate = $declineDate;
        $this->addedBy = $addedBy;
    }

}