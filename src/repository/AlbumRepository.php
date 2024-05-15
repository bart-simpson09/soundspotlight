<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Album.php';

class AlbumRepository extends Repository
{
    public function getAllAlbums($userId): array
    {
        $stmt = $this->database->connect()->prepare("
        SELECT albums.*, 
               authors.name AS authorname,
               categories.name AS categoryname,
               languages.name AS languagename,
               (CASE WHEN favorites.albumid IS NULL THEN FALSE ELSE TRUE END) AS isfavorite
        FROM albums
        INNER JOIN authors ON albums.authorid = authors.id
        INNER JOIN categories ON albums.categoryid = categories.id
        INNER JOIN languages ON albums.languageid = languages.id
        LEFT JOIN favorites ON albums.id = favorites.albumid AND favorites.userid = :userid
        WHERE albums.status = 'Approved'
    ");
        $stmt->bindParam(':userid', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getTopAlbums($userId): array
    {
        $stmt = $this->database->connect()->prepare("
        SELECT albums.*, 
               authors.name AS authorname,
               categories.name AS categoryname,
               languages.name AS languagname,
               (CASE WHEN favorites.albumid IS NULL THEN FALSE ELSE TRUE END) AS isfavorite
        FROM albums
        INNER JOIN authors ON albums.authorid = authors.id
        INNER JOIN categories ON albums.categoryid = categories.id
        INNER JOIN languages ON albums.languageid = languages.id
        LEFT JOIN favorites ON albums.id = favorites.albumid AND favorites.userid = :userid
        WHERE albums.status = 'Approved'
        ORDER BY averagerate DESC
        LIMIT 5
    ");
        $stmt->bindParam(':userid', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getFilteredAlbums($userId, $albumTitle = null, $artistName = null, $categoryId = null, $languageId = null)
    {
        $conditions = ["albums.status = 'Approved'"];
        $params = [];

        $params[':userid'] = $userId;

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

        $query = "
        SELECT albums.*, 
               authors.name AS authorname,
               categories.name AS categoryname,
               languages.name AS languagename,
               (CASE WHEN favorites.albumid IS NULL THEN FALSE ELSE TRUE END) AS isfavorite
        FROM albums
        INNER JOIN authors ON albums.authorid = authors.id
        INNER JOIN categories ON albums.categoryid = categories.id
        INNER JOIN languages ON albums.languageid = languages.id
        LEFT JOIN favorites ON albums.id = favorites.albumid AND favorites.userid = :userid
    ";

        if (!empty($conditions)) {
            $query .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $stmt = $this->database->connect()->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addAlbum($albumTitle, $authorId, $languageId, $categoryId, $numberOfSongs, $description, $cover, $releaseDate, $uploadDate, $addedBy)
    {
        if ($this->isAdmin($addedBy)) {
            $stmt = $this->database->connect()->prepare('
            INSERT INTO albums (albumtitle, authorid, languageid, categoryid, numberofsongs, description, cover, releasedate, uploaddate, addedby, status)
            VALUES (:albumtitle, :authorid, :languageid, :categoryid, :numberofsongs, :description, :cover, :releasedate, :uploaddate, :addedby, :status);
        ');
            $stmt->bindValue(':status', 'Approved');
        } else {
            $stmt = $this->database->connect()->prepare('
            INSERT INTO albums (albumtitle, authorid, languageid, categoryid, numberofsongs, description, cover, releasedate, uploaddate, addedby)
            VALUES (:albumtitle, :authorid, :languageid, :categoryid, :numberofsongs, :description, :cover, :releasedate, :uploaddate, :addedby);
        ');
        }
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

    private function isAdmin($userId): bool
    {
        $stmt = $this->database->connect()->prepare('
        SELECT role FROM users WHERE id = :userid;
    ');
        $stmt->bindValue(':userid', $userId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result && $result['role'] === 'admin';
    }

    public function getAlbumById($id, $userId)
    {
        $stmt = $this->database->connect()->prepare('
        SELECT albums.*, 
           authors.name AS authorname,
           categories.name AS categoryname,
           languages.name AS languagename,
           (CASE WHEN favorites.albumid IS NULL THEN FALSE ELSE TRUE END) AS isfavorite
    FROM albums
    INNER JOIN authors ON albums.authorid = authors.id
    INNER JOIN categories ON albums.categoryid = categories.id
    INNER JOIN languages ON albums.languageid = languages.id
    LEFT JOIN favorites ON albums.id = favorites.albumid AND favorites.userid = :userid
    WHERE albums.id = :id
    ');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':userid', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $albumData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$albumData) {
            return null;
        }

        return $albumData;
    }

    public function getAlbumsAddedByUser($userId): array
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
        WHERE albums.addedby = :userid
        ORDER BY albums.status DESC
    ');

        $stmt->bindValue(':userid', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}