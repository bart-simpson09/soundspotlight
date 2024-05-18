<?php

class Review
{
    private $id;
    private $authorId;
    private $albumId;
    private $createDate;
    private $rate;
    private $content;
    private $status;

    public function __construct(?int $id, int $authorId, int $albumId, string $createDate, int $rate, string $content, ?string $status)
    {
        $this->id = $id;
        $this->authorId = $authorId;
        $this->albumId = $albumId;
        $this->createDate = $createDate;
        $this->rate = $rate;
        $this->content = $content;
        $this->status = $status;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function getAlbumId(): int
    {
        return $this->albumId;
    }

    public function getCreateDate(): string
    {
        return $this->createDate;
    }

    public function getRate(): int
    {
        return $this->rate;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

}