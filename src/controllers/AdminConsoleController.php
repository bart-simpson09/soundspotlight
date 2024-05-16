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
        //$pendingAlbums = $this->albumsRepository->getPendingAlbums();
        //$allUsers = $this->userRepository->getAllUsers();

        print $this->render('/adminConsole', [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'avatar' => $user->getAvatar(),
            'isAdmin' => $user->getRole(),
            'pendingReviews' => $pendingReviews]);
        //'pendingAlbums' => $pendingAlbums,
        //'allUsers' => $allUsers]);
    }

    public function changeReviewStatus()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-Type: application/json');
            http_response_code(200);

            error_log($decoded["decision"]);
            error_log($decoded["reviewId"]);

            if ($decoded['decision'] == "Approve") {
                $this->reviewsRepository->changeReviewStatus((int)$decoded['reviewId'], "Approved");
            }

            if ($decoded['decision'] == "Decline") {
                $this->reviewsRepository->changeReviewStatus((int)$decoded['reviewId'], "Declined");
            }

            echo json_encode($this->reviewsRepository->getPendingReviews());
        }
    }
}