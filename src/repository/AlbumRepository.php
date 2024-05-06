<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Album.php';

class AlbumRepository extends Repository
{
    public function getAllAlbums(): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM albums
        ');
        $stmt->execute();

        $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $albumsResult = [];

        foreach ($albums as $album) {
            $albumsResult[] = new Album(
                $album['id'],
                $album['albumtitle'],
                $album['authorid'],
                $album['languageid'],
                $album['categoryid'],
                $album['numberofsongs'],
                $album['description'],
                $album['averagerate'],
                $album['cover'],
                $album['releasedate'],
                $album['uploaddate'],
                $album['approvedate'],
                $album['declinedate'],
                $album['addedby']
            );
        }

        return $albumsResult;
    }

}