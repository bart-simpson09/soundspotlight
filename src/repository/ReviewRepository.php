<?php

require_once 'Repository.php';

class ReviewRepository extends Repository
{
    public function getAlbumReviews($albumId): array
    {
        $stmt = $this->database->connect()->prepare("
        SELECT reviews.*, 
               users.firstname AS authorfirstname,
               users.lastname AS authorlastname,
               users.avatar AS authoravatar
        FROM reviews
        INNER JOIN users ON reviews.authorid = users.id
        WHERE reviews.albumid = :albumid AND reviews.status = 'Approved'
    ");
        $stmt->bindParam(':albumid', $albumId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addAlbumReview($userId, $albumId, $creationDate, $rate, $content): bool
    {
        try {
            $stmt = $this->database->connect()->prepare('
            INSERT INTO reviews (authorid, albumid, createddate, rate, content) VALUES (?, ?, ?, ?, ?)
        ');
            $stmt->execute([
                $userId, $albumId, $creationDate, $rate, $content
            ]);

            //TODO
            //Update album rate while adding review

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

}