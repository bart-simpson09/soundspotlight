<?php

require_once 'Repository.php';

class FavoriteRepository extends Repository
{

    public function getUserFavoriteAlbums($userId): array
    {
        $stmt = $this->database->connect()->prepare('
        SELECT albums.*, 
               authors.name AS authorname,
               categories.name AS categoryname,
               languages.name AS languagename,
               (CASE WHEN f2.albumid IS NULL THEN FALSE ELSE TRUE END) AS isfavorite
        FROM albums
        INNER JOIN authors ON albums.authorid = authors.id
        INNER JOIN categories ON albums.categoryid = categories.id
        INNER JOIN languages ON albums.languageid = languages.id
        LEFT JOIN favorites f1 ON albums.id = f1.albumid
        LEFT JOIN favorites f2 ON albums.id = f2.albumid AND f2.userid = :userid
        WHERE f1.userid = :userid
    ');
        $stmt->bindParam(':userid', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function doesFavoriteMatchExists($albumid, $userId): bool
    {
        $stmt = $this->database->connect()->prepare('
        SELECT COUNT(*) FROM favorites WHERE albumid = :albumid AND userid = :userid
    ');
        $stmt->bindParam(':albumid', $albumid, PDO::PARAM_INT);
        $stmt->bindParam(':userid', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $count = (int)$stmt->fetchColumn();

        return $count > 0;
    }


    public function addToFavorites($albumid, $userid)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO favorites (userid, albumid) VALUES (:userid, :albumid)
        ');
        $stmt->bindParam(':albumid', $albumid, PDO::PARAM_INT);
        $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function removeFromFavorites($albumid, $userid)
    {
        $stmt = $this->database->connect()->prepare('
            DELETE FROM favorites WHERE userid = :userid AND albumid = :albumid
        ');
        $stmt->bindParam(':albumid', $albumid, PDO::PARAM_INT);
        $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
        $stmt->execute();
    }


}