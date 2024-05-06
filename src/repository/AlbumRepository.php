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

    public function getFilteredAlbums($albumTitle = null, $artistName = null, $categoryId = null, $languageId = null)
    {
        // Zbieranie warunków dla zapytania
        $conditions = [];
        $params = [];

        if (!empty($albumTitle)) {
            $albumTitle = '%' . strtolower($albumTitle) . '%';
            $conditions[] = "LOWER(albums.albumtitle) LIKE :albumtitle";
            $params[':albumtitle'] = $albumTitle;
        }

        if (!empty($artistName)) {
            $artistName = '%' . strtolower($artistName) . '%';
            $conditions[] = "LOWER(authors.name) LIKE :artistname";
            $params[':artistname'] = $artistName;
        }

        if (!empty($categoryId)) {
            $conditions[] = "albums.categoryid = :categoryid";
            $params[':categoryid'] = $categoryId;
        }

        if (!empty($languageId)) {
            $conditions[] = "albums.languageid = :languageid";
            $params[':languageid'] = $languageId;
        }

        // Budowanie zapytania z dynamicznymi warunkami
        $query = '
        SELECT albums.*, 
               authors.name AS authorname,
               categories.name AS categoryname,
               languages.name AS languagename
        FROM albums
        INNER JOIN authors ON albums.authorid = authors.id
        INNER JOIN categories ON albums.categoryid = categories.id
        INNER JOIN languages ON albums.languageid = languages.id
    ';

        if (!empty($conditions)) {
            $query .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $stmt = $this->database->connect()->prepare($query);

        // Przypisanie wartości do zapytania
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}