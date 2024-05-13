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
               languages.name AS languagename
        FROM albums
        INNER JOIN authors ON albums.authorid = authors.id
        INNER JOIN categories ON albums.categoryid = categories.id
        INNER JOIN languages ON albums.languageid = languages.id
        INNER JOIN favorites ON albums.id = favorites.albumid
        WHERE favorites.userid = :userid
    ');
        $stmt->bindParam(':userid', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}