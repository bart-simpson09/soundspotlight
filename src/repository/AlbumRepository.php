<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Album.php';

class AlbumRepository extends Repository
{
    public function getAllAlbums(): array
    {
        $stmt = $this->database->connect()->prepare('
        SELECT albums.*, 
               authors.name AS authorname,
               categories.name AS categoryname,
               languages.name AS languagename
        FROM albums
        INNER JOIN authors ON albums.authorid = authors.id
        INNER JOIN categories ON albums.categoryid = categories.id
        INNER JOIN languages ON albums.languageid = languages.id
    ');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function addAlbum($albumTitle, $authorId, $languageId, $categoryId, $numberOfSongs, $description, $cover, $releaseDate, $uploadDate, $addedBy)
    {
        $stmt = $this->database->connect()->prepare('
    INSERT INTO albums (albumtitle, authorid, languageid, categoryid, numberofsongs, description, cover, releasedate, uploaddate, addedby)
    VALUES (:albumtitle, :authorid, :languageid, :categoryid, :numberofsongs, :description, :cover, :releasedate, :uploaddate, :addedby);
  ');
        $stmt->bindValue(':albumtitle', $albumTitle);
        $stmt->bindValue(':authorid', $authorId);
        $stmt->bindValue(':languageid', $languageId);
        $stmt->bindValue(':categoryid', $categoryId);
        $stmt->bindValue(':numberofsongs', $numberOfSongs);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':cover', $cover);
        $stmt->bindValue(':releasedate', $releaseDate);
        $stmt->bindValue(':uploaddate', $uploadDate);
        $stmt->bindValue(':addedby', $addedBy);
        $stmt->execute();
    }
}