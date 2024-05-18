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
        SELECT reviews.*, 
               users.firstname AS authorfirstname,
               users.lastname AS authorlastname,
               albums.albumtitle AS albumname,
               authors.name AS albumauthorname
        FROM reviews
        INNER JOIN users ON reviews.authorid = users.id
        INNER JOIN albums ON reviews.albumid = albums.id
        INNER JOIN authors ON albums.authorid = authors.id
        WHERE reviews.status = 'Pending'
    ");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function addAlbumReview(Review $newReview)
    {
        try {
            // Add review to DB
            if ($this->isAdmin($newReview->getAuthorId())) {
                $stmt = $this->database->connect()->prepare('
            INSERT INTO reviews (authorid, albumid, createddate, rate, content, status) 
            VALUES (?, ?, ?, ?, ?, ?)
        ');
                $stmt->execute([
                    $newReview->getAuthorId(), $newReview->getAlbumId(), $newReview->getCreateDate(), $newReview->getRate(), $newReview->getContent(), 'Approved'
                ]);
            } else {
                $stmt = $this->database->connect()->prepare('
            INSERT INTO reviews (authorid, albumid, createddate, rate, content) 
            VALUES (?, ?, ?, ?, ?)
        ');
                $stmt->execute([
                    $newReview->getAuthorId(), $newReview->getAlbumId(), $newReview->getCreateDate(), $newReview->getRate(), $newReview->getContent()
                ]);
            }

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

    private function isAdmin($userId)
    {
        $stmt = $this->database->connect()->prepare('
        SELECT role FROM users WHERE id = :userid;
    ');
        $stmt->bindValue(':userid', $userId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result && $result['role'] === 'admin';
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
        ORDER BY reviews.status DESC
    ');

        $stmt->bindValue(':userid', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function changeReviewStatus($reviewId, $status)
    {
        //var_dump($reviewId, $status);
        $stmt = $this->database->connect()->prepare('
            UPDATE reviews
            SET status = :status
            WHERE id = :reviewId
        ');
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    }

}