<?php

require_once 'AppController.php';
require_once __DIR__ . '/../SessionManager.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/AlbumRepository.php';
require_once __DIR__ . '/../repository/AuthorRepository.php';
require_once __DIR__ . '/../repository/CategoryRepository.php';
require_once __DIR__ . '/../repository/LanguageRepository.php';

class AddAlbumController extends AppController
{
    private $userRepository;
    private $categoryRepository;
    private $languageRepository;
    private $albumRepository;
    private $authorRepository;

    const UPLOAD_DIRECTORY = '/../public/assets/imgs/covers/';

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->languageRepository = new LanguageRepository();
        $this->albumRepository = new AlbumRepository();
        $this->authorRepository = new AuthorRepository();
    }

    public function addAlbum()
    {
        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");
        $userEmail = $userSession->__get("userEmail");

        if ($userId === null) {
            $this->redirectToLogin();
        }

        $user = $this->userRepository->getUser($userEmail);
        $data = $this->prepareData($user);

        if ($this->isPost()) {
            $data = $this->handlePostRequest($data, $userId);
        }

        print $this->render('/addAlbum', $data);
    }

    private function redirectToLogin()
    {
        $url = "http://{$_SERVER['HTTP_HOST']}/login";
        header("Location: $url");
        exit;
    }

    private function prepareData($user): array
    {
        return [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'avatar' => $user->getAvatar(),
            'isAdmin' => $user->getRole(),
            'categories' => $this->categoryRepository->getCategories(),
            'languages' => $this->languageRepository->getLanguages()
        ];
    }

    private function handlePostRequest(array $data, int $userId): array
    {
        $albumCover = $_FILES['albumCover'];
        $albumTitle = $_POST['albumTitle'];
        $authorName = $_POST['authorName'];
        $language = $_POST['language'];
        $category = $_POST['category'];
        $releaseDate = $_POST['releaseDate'];
        $songsNumber = $_POST['songsNumber'];
        $description = $_POST['description'];

        if ($this->validateAlbumName($albumTitle)) {
            $this->uploadAlbumCover($albumCover);
            $authorId = $this->getOrCreateAuthorId($authorName);

            $album = new Album(null, $albumTitle, $authorId, $language, $category, $songsNumber, $description, null, $albumCover['name'], $releaseDate, date('Y-m-d H:i:s'), $userId);
            $this->albumRepository->addAlbum($album);

            $this->redirectToDashboard();
        } else {
            $data['errorMessage'] = "Album with this name already exists!";
        }

        return $data;
    }

    private function uploadAlbumCover($albumCover)
    {
        move_uploaded_file($albumCover['tmp_name'], dirname(__DIR__) . self::UPLOAD_DIRECTORY . $albumCover['name']);
    }

    private function getOrCreateAuthorId(string $authorName): int
    {
        $authorId = $this->getAuthorId($authorName);
        if ($authorId === null) {
            $newAuthor = $this->authorRepository->addAuthor($authorName);
            $authorId = $newAuthor->getAuthorId();
        }

        return $authorId;
    }

    private function redirectToDashboard()
    {
        $url = "http://{$_SERVER['HTTP_HOST']}/dashboard";
        header("Location: $url");
        exit;
    }

    private function validateAlbumName(string $albumTitle): bool
    {
        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");

        $allAlbums = $this->albumRepository->getAllAlbums($userId);
        foreach ($allAlbums as $album) {
            if ($album['albumtitle'] === $albumTitle) {
                return false;
            }
        }

        return true;
    }

    private function getAuthorId(string $authorName): ?int
    {
        $allAuthors = $this->authorRepository->getAuthors();
        foreach ($allAuthors as $author) {
            if ($author->getAuthorName() === $authorName) {
                return $author->getAuthorId();
            }
        }

        return null;
    }
}
