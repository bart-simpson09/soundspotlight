<?php

require_once 'AppController.php';
require_once __DIR__ . '/../SessionManager.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/AlbumRepository.php';
require_once __DIR__ . '/../repository/AuthorRepository.php';
require_once __DIR__ . '/../repository/CategoryRepository.php';
require_once __DIR__ . '/../repository/LanguageRepository.php';

class DashboardController extends AppController
{

    private $userRepository;
    private $albumRepository;
    private $authorRepository;
    private $categoryRepository;
    private $languageRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->albumRepository = new AlbumRepository();
        $this->authorRepository = new AuthorRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->languageRepository = new LanguageRepository();
    }

    public function dashboard()
    {

        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");
        $userEmail = $userSession->__get("userEmail");

        $user = $this->userRepository->getUser($userEmail);
        $allAlbums = $this->albumRepository->getAllAlbums();

        $shortenAlbums = [];

        foreach ($allAlbums as $album) {

            $author = $this->authorRepository->getAuthorNameById($album->getAuthorId());
            $authorName = $author->getAuthorName();

            $category = $this->categoryRepository->getCategoryNameById($album->getCategoryId());
            $categoryName = $category->getCategoryName();

            $language = $this->languageRepository->getLanguageNameById($album->getLanguageId());
            $languageName = $language->getLanguageName();

            $shortenAlbums[] = [
                'cover' => $album->getCover(),
                'name' => $album->getAlbumTitle(),
                'author' => $authorName,
                'releaseDate' => $album->getReleaseDate(),
                'rate' => $album->getAverageRate(),
                'category' => $categoryName,
                'language' => $languageName
            ];
        }


        if ($userId == null) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: $url/login");
        }


        print $this->render('/dashboard', [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'avatar' => $user->getAvatar(),
            'isAdmin' => $user->getRole(),
            'shortenAlbums' => $shortenAlbums,
            'categories' => $this->categoryRepository->getCategories(),
            'languages' => $this->languageRepository->getLanguages()]);
    }
}