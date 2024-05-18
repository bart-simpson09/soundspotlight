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

        if ($userId === null) {
            $this->redirectToLogin();
        }

        $user = $this->userRepository->getUser($userEmail);
        $data = $this->prepareData($user, $userId);

        print $this->render('/adminConsole', $data);
    }

    private function redirectToLogin()
    {
        $url = "http://{$_SERVER['HTTP_HOST']}/login";
        header("Location: $url");
        exit;
    }

    private function prepareData($user, $userId): array
    {
        return [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'avatar' => $user->getAvatar(),
            'isAdmin' => $user->getRole(),
            'pendingReviews' => $this->reviewsRepository->getPendingReviews(),
            'pendingAlbums' => $this->albumsRepository->getPendingAlbums(),
            'allUsers' => $this->userRepository->getAllUsers(),
            'loggedUserId' => $userId
        ];
    }

    public function changeReviewStatus()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-Type: application/json');
            http_response_code(200);

            $this->processReviewStatusChange($decoded);

            echo json_encode($this->reviewsRepository->getPendingReviews());
        }
    }

    private function processReviewStatusChange(array $decoded)
    {
        if ($decoded['decision'] == "Approve") {
            $this->reviewsRepository->changeReviewStatus((int)$decoded['reviewId'], "Approved");
        } elseif ($decoded['decision'] == "Decline") {
            $this->reviewsRepository->changeReviewStatus((int)$decoded['reviewId'], "Declined");
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

            $this->processAlbumStatusChange($decoded);

            echo json_encode($this->albumsRepository->getPendingAlbums());
        }
    }

    private function processAlbumStatusChange(array $decoded)
    {
        if ($decoded['decision'] == "Approve") {
            $this->albumsRepository->changeAlbumStatus((int)$decoded['albumId'], "Approved");
        } elseif ($decoded['decision'] == "Decline") {
            $this->albumsRepository->changeAlbumStatus((int)$decoded['albumId'], "Declined");
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

            $this->processUserManagement($decoded);

            echo json_encode($this->userRepository->getAllUsers());
        }
    }

    private function processUserManagement(array $decoded)
    {
        if ($decoded['decision'] == "removeAdmin") {
            $this->userRepository->changeUserRole((int)$decoded['userId'], "removeAdmin");
        } elseif ($decoded['decision'] == "addAdmin") {
            $this->userRepository->changeUserRole((int)$decoded['userId'], "addAdmin");
        } elseif ($decoded['decision'] == "deleteUser") {
            $this->userRepository->deleteUser((int)$decoded['userId']);
        }
    }
}