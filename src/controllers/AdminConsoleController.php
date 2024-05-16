<?php

require_once 'AppController.php';
require_once __DIR__ . '/../SessionManager.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class AdminConsoleController extends AppController
{

    private $userRepository;
    private $albumsRepository;
    private $reviewsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->albumsRepository = new AlbumRepository();
        $this->reviewsRepository = new ReviewRepository();
    }

    public function adminConsole()
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
        $userReviews = $this->reviewsRepository->getReviewsAddedByUser($userId);

        print $this->render('/adminConsole', [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'avatar' => $user->getAvatar(),
            'isAdmin' => $user->getRole(),
            'userAlbums' => $userAlbums,
            'userReviews' => $userReviews]);
    }
}