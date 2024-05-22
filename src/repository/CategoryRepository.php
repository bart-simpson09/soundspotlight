<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Category.php';

class CategoryRepository extends Repository
{
    public function getCategories(): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM categories
        ');
        $stmt->execute();

        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categoriesResult = [];

        foreach ($categories as $category) {
            $categoriesResult[] = new Category(
                $category['id'],
                $category['name']
            );
        }

        return $categoriesResult;
    }

    public function getCategoryNameById(int $id): ?Category
    {
        $stmt = $this->database::getInstance()->connect()->prepare('
            SELECT * FROM categories WHERE id = :categoryid
        ');
        $stmt->bindParam(':categoryid', $id, PDO::PARAM_STR);
        $stmt->execute();

        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($category) {
            return new Category($category['id'], $category['name']);
        } else {
            return null;
        }
    }
}