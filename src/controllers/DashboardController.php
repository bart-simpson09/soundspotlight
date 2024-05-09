<?php

require_once 'AppController.php';
require_once __DIR__ . '/../SessionManager.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/AlbumRepository.php';
require_once __DIR__ . '/../repository/AuthorRepository.php';
require_once __DIR__ . '/../repository/CategoryRepository.php';
require_once __DIR__ . '/../repository/LanguageRepository.php';
require_once __DIR__ . '/../repository/FavoriteRepository.php';

class DashboardController extends AppController
{

    private $userRepository;
    private $albumRepository;
    private $categoryRepository;
    private $languageRepository;

    //private $favoriteRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->albumRepository = new AlbumRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->languageRepository = new LanguageRepository();
        //$this->favoriteRepository = new FavoriteRepository();
    }

    public function dashboard()
    {
        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");
        $userEmail = $userSession->__get("userEmail");

        $user = $this->userRepository->getUser($userEmail);
        $allAlbums = $this->albumRepository->getAllAlbums($userId);
        //$userFavorites = $this->favoriteRepository->getUserFavoriteAlbums($userId);


        if ($userId == null) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: $url/login");
        }

        print $this->render('/dashboard', [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'avatar' => $user->getAvatar(),
            'isAdmin' => $user->getRole(),
            'allAlbums' => $allAlbums,
            'categories' => $this->categoryRepository->getCategories(),
            'languages' => $this->languageRepository->getLanguages()]);
    }

    public function searchAlbum()
    {
        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");

        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-Type: application/json');
            http_response_code(200);

            echo json_encode($this->albumRepository->getFilteredAlbums((int)$userId, $decoded['title'], $decoded['artist'], (int)$decoded['category'], (int)$decoded['language']));
        }
    }
}