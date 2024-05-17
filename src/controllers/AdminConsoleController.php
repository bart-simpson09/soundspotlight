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

        $pendingReviews = $this->reviewsRepository->getPendingReviews();
        $pendingAlbums = $this->albumsRepository->getPendingAlbums();
        $allUsers = $this->userRepository->getAllUsers();

        print $this->render('/adminConsole', [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'avatar' => $user->getAvatar(),
            'isAdmin' => $user->getRole(),
            'pendingReviews' => $pendingReviews,
            'pendingAlbums' => $pendingAlbums,
            'allUsers' => $allUsers,
            'loggedUserId' => $userId]);
    }

    public function changeReviewStatus()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-Type: application/json');
            http_response_code(200);

            if ($decoded['decision'] == "Approve") {
                $this->reviewsRepository->changeReviewStatus((int)$decoded['reviewId'], "Approved");
            }

            if ($decoded['decision'] == "Decline") {
                $this->reviewsRepository->changeReviewStatus((int)$decoded['reviewId'], "Declined");
            }

            echo json_encode($this->reviewsRepository->getPendingReviews());
        }
    }

    public function changeAlbumStatus()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-Type: application/json');
            http_response_code(200);

            if ($decoded['decision'] == "Approve") {
                $this->albumsRepository->changeAlbumStatus((int)$decoded['albumId'], "Approved");
            }

            if ($decoded['decision'] == "Decline") {
                $this->albumsRepository->changeAlbumStatus((int)$decoded['albumId'], "Declined");
            }

            echo json_encode($this->albumsRepository->getPendingAlbums());
        }
    }

    public function manageUser()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-Type: application/json');
            http_response_code(200);

            if ($decoded['decision'] == "removeAdmin") {
                $this->userRepository->changeUserRole((int)$decoded['userId'], "removeAdmin");
            }

            if ($decoded['decision'] == "addAdmin") {
                $this->userRepository->changeUserRole((int)$decoded['userId'], "addAdmin");
            }

            if ($decoded['decision'] == "deleteUser") {
                $this->userRepository->deleteUser((int)$decoded['userId']);
            }

            echo json_encode($this->userRepository->getAllUsers());
        }
    }
}