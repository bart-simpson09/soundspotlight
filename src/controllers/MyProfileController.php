<?php

require_once 'AppController.php';
require_once __DIR__ . '/../SessionManager.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class MyProfileController extends AppController
{

    private $userRepository;
    private $albumsRepository;
    const UPLOAD_DIRECTORY = '/../public/assets/imgs/avatars/';

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->albumsRepository = new AlbumRepository();
    }

    public function myProfile()
    {
        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");
        $userEmail = $userSession->__get("userEmail");

        $user = $this->userRepository->getUser($userEmail);

        if ($userId == null) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: $url/login");
        }

        $userAlbums = $this->albumsRepository->getAlbumsAddedByUser($userId);

        print $this->render('/myProfile', [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'avatar' => $user->getAvatar(),
            'isAdmin' => $user->getRole(),
            'userAlbums' => $userAlbums]);
    }

    public function changePhoto()
    {
        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");
        $userEmail = $userSession->__get("userEmail");

        $user = $this->userRepository->getUser($userEmail);

        if ($this->isPost()) {
            $newPhoto = $_FILES['newPhoto'];
            move_uploaded_file($newPhoto['tmp_name'], dirname(__DIR__) . self::UPLOAD_DIRECTORY . $newPhoto['name']);
            $this->userRepository->changePhoto($userId, $newPhoto['name']);

            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: $url/myProfile");
        } else {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: $url/login");
        }
    }
}