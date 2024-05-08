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
    private $messages = [];

    const MAX_FILE_SIZE = 1024 * 1024;
    const UPLOAD_DIRECTORY = '/../public/assets/imgs/covers/';

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->languageRepository = new LanguageRepository();
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

        print $this->render('/addAlbum', [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'avatar' => $user->getAvatar(),
            'isAdmin' => $user->getRole(),
            'categories' => $this->categoryRepository->getCategories(),
            'languages' => $this->languageRepository->getLanguages()]);

        if ($this->isPost() && is_uploaded_file($_FILES['albumCover']['tmp_name']) && $this->validate($_FILES['albumCover'])) {

            move_uploaded_file($_FILES['albumCover']['tmp_name'], dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['albumCover']['name']);

            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: $url/dashboard");
            exit;
        }

        ob_end_flush();
    }

    private function validate(array $albumCover): bool
    {
        if ($albumCover['size'] > self::MAX_FILE_SIZE) {
            $this->messages[] = 'File is too big!';
            return false;
        }

        return true;
    }
}