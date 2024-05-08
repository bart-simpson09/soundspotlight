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

    const MAX_FILE_SIZE = 1024 * 1024;
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
        ob_start();

        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");
        $userEmail = $userSession->__get("userEmail");

        $user = $this->userRepository->getUser($userEmail);

        if ($userId == null) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: $url/login");
            exit;
        }

        $data = [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'avatar' => $user->getAvatar(),
            'isAdmin' => $user->getRole(),
            'categories' => $this->categoryRepository->getCategories(),
            'languages' => $this->languageRepository->getLanguages()
        ];

        if ($this->isPost()) {
            $albumCover = $_FILES['albumCover'];
            $albumTitle = $_POST['albumTitle'];
            $authorName = $_POST['authorName'];
            $language = $_POST['language'];
            $category = $_POST['category'];
            $releaseDate = $_POST['releaseDate'];
            $songsNumber = $_POST['songsNumber'];
            $description = $_POST['description'];

            if ($this->validateAlbumName($albumTitle)) {
                move_uploaded_file($albumCover['tmp_name'], dirname(__DIR__) . self::UPLOAD_DIRECTORY . $albumCover['name']);

                if ($this->getAuthorId($authorName) != null) {
                    $authorId = $this->getAuthorId($authorName);
                } else {
                    $newAuthor = $this->authorRepository->addAuthor($authorName);
                    $authorId = $newAuthor->getAuthorId();
                }

                $this->albumRepository->addAlbum($albumTitle, $authorId, $language, $category, $songsNumber, $description, $albumCover['name'], $releaseDate, date("Y-m-d"), $userId);

                $url = "http://$_SERVER[HTTP_HOST]";
                header("Location: $url/dashboard");
                exit;
            } else {
                $data = [
                    'firstName' => $user->getFirstName(),
                    'lastName' => $user->getLastName(),
                    'avatar' => $user->getAvatar(),
                    'isAdmin' => $user->getRole(),
                    'categories' => $this->categoryRepository->getCategories(),
                    'languages' => $this->languageRepository->getLanguages(),
                    'errorMessage' => "Album with this name already exists!"
                ];
            }
        }

        print $this->render('/addAlbum', $data);

        ob_end_flush();
    }

    private function validateAlbumName($albumTitle): bool
    {
        $allAlbums = $this->albumRepository->getAllAlbums();
        foreach ($allAlbums as $album) {
            if ($album['albumtitle'] == $albumTitle) {
                return false;
            }
        }

        return true;
    }

    private function getAuthorId($authorName): ?int
    {
        $allAuthors = $this->authorRepository->getAuthors();
        foreach ($allAuthors as $author) {
            if ($author->getAuthorName() == $authorName) {
                return $author->getAuthorId();
            }
        }

        return null;
    }
}