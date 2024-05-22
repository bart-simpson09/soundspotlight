<?php

require_once 'AppController.php';
require_once __DIR__ . '/../SessionManager.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/AlbumRepository.php';
require_once __DIR__ . '/../repository/AuthorRepository.php';
require_once __DIR__ . '/../repository/CategoryRepository.php';
require_once __DIR__ . '/../repository/LanguageRepository.php';

class TopAlbumsController extends AppController
{
    private $userRepository;
    private $albumRepository;
    private $categoryRepository;
    private $languageRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->albumRepository = new AlbumRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->languageRepository = new LanguageRepository();
    }

    public function topAlbums()
    {
        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");
        $userEmail = $userSession->__get("userEmail");

        if ($userId === null) {
            $this->redirectToLogin();
        }

        $user = $this->userRepository->getUser($userEmail);
        $topAlbums = $this->albumRepository->getTopAlbums($userId);

        print $this->render('/topAlbums', [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'avatar' => $user->getAvatar(),
            'isAdmin' => $user->getRole(),
            'allAlbums' => $topAlbums,
            'categories' => $this->categoryRepository->getCategories(),
            'languages' => $this->languageRepository->getLanguages()
        ]);
    }

    private function redirectToLogin()
    {
        $url = "http://{$_SERVER['HTTP_HOST']}/login";
        header("Location: $url");
        exit();
    }
}