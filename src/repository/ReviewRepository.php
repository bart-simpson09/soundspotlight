<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Review.php';

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
        ORDER BY createddate DESC 
    ");
        $stmt->bindParam(':albumid', $albumId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPendingReviews(): array
    {
        $stmt = $this->database->connect()->prepare("
        SELECT * FROM pending_reviews;
    ");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function addAlbumReview(Review $newReview): bool
    {
        try {
            // Add review to DB
            $stmt = $this->database->connect()->prepare('
            INSERT INTO reviews (authorid, albumid, createddate, rate, content, status) 
            VALUES (?, ?, ?, ?, ?, ?)
        ');
            $stmt->execute([
                $newReview->getAuthorId(), $newReview->getAlbumId(), $newReview->getCreateDate(), $newReview->getRate(), $newReview->getContent(), $newReview->getStatus()
            ]);

            // Calculate the new avg rate for the album
            $stmt = $this->database->connect()->prepare('
            SELECT AVG(rate) as avg_rate
            FROM reviews
            WHERE albumid = ?
        ');
            $stmt->execute([$newReview->getAlbumId()]);
            $avgRate = $stmt->fetchColumn();
            $avgRate = round($avgRate, 1);

            // Update the album avg rate
            $stmt = $this->database->connect()->prepare('
            UPDATE albums
            SET averagerate = ?
            WHERE id = ?
        ');
            $stmt->execute([$avgRate, $newReview->getAlbumId()]);

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
        ORDER BY reviews.status
    ');

        $stmt->bindValue(':userid', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function changeReviewStatus($reviewId, $status)
    {
        $stmt = $this->database->connect()->prepare('
            UPDATE reviews
            SET status = :status
            WHERE id = :reviewId
        ');
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);
        $stmt->execute();
    }

}