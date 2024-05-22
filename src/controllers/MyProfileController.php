<?php

require_once 'AppController.php';
require_once __DIR__ . '/../SessionManager.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/AlbumRepository.php';
require_once __DIR__ . '/../repository/ReviewRepository.php';

class MyProfileController extends AppController
{
    private $userRepository;
    private $albumsRepository;
    private $reviewsRepository;
    const UPLOAD_DIRECTORY = '/../public/assets/imgs/avatars/';

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->albumsRepository = new AlbumRepository();
        $this->reviewsRepository = new ReviewRepository();
    }

    public function myProfile()
    {
        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");
        $userEmail = $userSession->__get("userEmail");

        if ($userId === null) {
            $this->redirectToLogin();
        }

        $user = $this->userRepository->getUser($userEmail);
        $userAlbums = $this->albumsRepository->getAlbumsAddedByUser($userId);
        $userReviews = $this->reviewsRepository->getReviewsAddedByUser($userId);

        print $this->render('/myProfile', [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'avatar' => $user->getAvatar(),
            'isAdmin' => $user->getRole(),
            'userAlbums' => $userAlbums,
            'userReviews' => $userReviews
        ]);
    }

    public function changePhoto()
    {
        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");

        if ($userId === null) {
            $this->redirectToLogin();
        }

        if ($this->isPost()) {
            $newPhoto = $_FILES['newPhoto'];
            move_uploaded_file($newPhoto['tmp_name'], dirname(__DIR__) . self::UPLOAD_DIRECTORY . $newPhoto['name']);
            $this->userRepository->changePhoto($userId, $newPhoto['name']);

            $this->redirectToProfile();
        } else {
            $this->redirectToLogin();
        }
    }

    private function redirectToLogin()
    {
        $url = "http://{$_SERVER['HTTP_HOST']}/login";
        header("Location: $url");
        exit;
    }

    private function redirectToProfile()
    {
        $url = "http://{$_SERVER['HTTP_HOST']}/myProfile";
        header("Location: $url");
        exit;
    }
}