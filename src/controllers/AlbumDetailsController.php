<?php

require_once 'AppController.php';
require_once __DIR__ . '/../SessionManager.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/AlbumRepository.php';
require_once __DIR__ . '/../repository/AuthorRepository.php';
require_once __DIR__ . '/../repository/CategoryRepository.php';
require_once __DIR__ . '/../repository/LanguageRepository.php';

class AlbumDetailsController extends AppController
{

    private $userRepository;
    private $albumRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->albumRepository = new AlbumRepository();
    }

    public function albumDetails($id)
    {
        if (!$id) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: $url/dashboard");
        }

        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");
        $userEmail = $userSession->__get("userEmail");

        $user = $this->userRepository->getUser($userEmail);

        if ($userId == null) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: $url/login");
        }

        $album = $this->albumRepository->getAlbumById($id, $userId);

        if (!$album) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: $url/dashboard");
        }

        print $this->render('/albumDetails', [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'avatar' => $user->getAvatar(),
            'isAdmin' => $user->getRole(),
            'album' => $album]);
    }
}