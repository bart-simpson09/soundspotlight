<?php


require_once 'Repository.php';
require_once __DIR__ . '/../models/Language.php';

class LanguageRepository extends Repository
{
    public function getLanguages(): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM languages
        ');
        $stmt->execute();

        $languages = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $languagesResult = [];

        foreach ($languages as $language) {
            $languagesResult[] = new Author(
                $language['id'],
                $language['name']
            );
        }

        return $languagesResult;
    }

    public function getLanguageNameById(int $id): ?Language
    {
        $stmt = $this->database::getInstance()->connect()->prepare('
            SELECT * FROM languages WHERE id = :languageid
        ');
        $stmt->bindParam(':languageid', $id, PDO::PARAM_STR);
        $stmt->execute();

        $language = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($language) {
            return new Language($language['id'], $language['name']);
        } else {
            return null;
        }
    }

}