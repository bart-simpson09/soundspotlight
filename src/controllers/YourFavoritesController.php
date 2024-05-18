<?php

require_once 'AppController.php';
require_once __DIR__ . '/../SessionManager.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/AlbumRepository.php';
require_once __DIR__ . '/../repository/AuthorRepository.php';
require_once __DIR__ . '/../repository/CategoryRepository.php';
require_once __DIR__ . '/../repository/LanguageRepository.php';
require_once __DIR__ . '/../repository/FavoriteRepository.php';

class YourFavoritesController extends AppController
{

    private $userRepository;
    private $categoryRepository;
    private $languageRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->languageRepository = new LanguageRepository();
        $this->favoriteRepository = new FavoriteRepository();
    }

    public function yourFavorites()
    {
        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");
        $userEmail = $userSession->__get("userEmail");

        if ($userId === null) {
            $this->redirectToLogin(); // Przeniesienie logiki przekierowania do oddzielnej metody
        }

        $user = $this->userRepository->getUser($userEmail);
        $favoriteAlbums = $this->favoriteRepository->getUserFavoriteAlbums($userId);

        print $this->render('/yourFavorites', [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'avatar' => $user->getAvatar(),
            'isAdmin' => $user->getRole(),
            'favoriteAlbums' => $favoriteAlbums,
            'categories' => $this->categoryRepository->getCategories(),
            'languages' => $this->languageRepository->getLanguages()]);
    }

    private function redirectToLogin()
    {
        $url = "http://{$_SERVER['HTTP_HOST']}/login";
        header("Location: $url");
        exit();
    }

    public function toggleFavorite()
    {
        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");

        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $albumId = $decoded["albumid"];

            $isfavorite = $this->favoriteRepository->doesFavoriteMatchExists($albumId, $userId);

            if ($isfavorite) {
                $this->favoriteRepository->removeFromFavorites($albumId, $userId);
            } else {
                $this->favoriteRepository->addToFavorites($albumId, $userId);
            }

            header('Content-Type: application/json');
            http_response_code(200);

            echo json_encode(['isfavorite' => $isfavorite, 'favoriteAlbums' => $this->favoriteRepository->getUserFavoriteAlbums($userId)]);
        }
    }
}