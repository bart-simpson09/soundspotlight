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
            // Add review to DB
            $stmt = $this->database->connect()->prepare('
            INSERT INTO reviews (authorid, albumid, createddate, rate, content) VALUES (?, ?, ?, ?, ?)
        ');
            $stmt->execute([
                $userId, $albumId, $creationDate, $rate, $content
            ]);

            // Calculate the new avg rate for the album
            $stmt = $this->database->connect()->prepare('
            SELECT AVG(rate) as avg_rate
            FROM reviews
            WHERE albumid = ?
        ');
            $stmt->execute([$albumId]);
            $avgRate = $stmt->fetchColumn();
            $avgRate = round($avgRate, 1);

            // Update the album avg rate
            $stmt = $this->database->connect()->prepare('
            UPDATE albums
            SET averagerate = ?
            WHERE id = ?
        ');
            $stmt->execute([$avgRate, $albumId]);

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getReviewsAddedByUser($userId): array
    {
        $stmt = $this->database->connect()->prepare('
        SELECT reviews.*, 
               albums.albumtitle AS albumtitle,
               authors.name AS albumauthorname
        FROM reviews
        INNER JOIN albums ON reviews.albumid = albums.id
        INNER JOIN authors ON albums.authorid = authors.id
        WHERE reviews.authorid = :userid
        ORDER BY albums.status DESC
    ');

        $stmt->bindValue(':userid', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}