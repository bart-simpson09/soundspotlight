<?php


require_once 'Repository.php';
require_once __DIR__ . '/../models/Author.php';

class AuthorRepository extends Repository
{
    public function getAuthors(): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM authors
        ');
        $stmt->execute();

        $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $authorsResult = [];

        foreach ($authors as $author) {
            $authorsResult[] = new Author(
                $author['id'],
                $author['name']
            );
        }

        return $authorsResult;
    }

    public function getAuthorNameById(int $id): ?Author
    {
        $stmt = $this->database::getInstance()->connect()->prepare('
            SELECT * FROM authors WHERE id = :authorid
        ');
        $stmt->bindParam(':authorid', $id, PDO::PARAM_STR);
        $stmt->execute();

        $author = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($author) {
            return new Author($author['id'], $author['name']);
        } else {
            return null;
        }
    }

    public function addAuthor(string $name): Author
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO authors (name) VALUES (:name)
        ');
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();

        $authorId = $this->database->connect()->lastInsertId();

        return new Author($authorId, $name);
    }

}