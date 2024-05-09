<?php

require_once 'Repository.php';

class FavoriteRepository extends Repository
{

    //NIEUŻYWANE
    public function getUserFavoriteAlbums($userId): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT albumid FROM favorite WHERE userid = :userid
        ');
        $stmt->bindValue(':userid', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}