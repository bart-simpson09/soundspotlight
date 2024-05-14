<?php

require_once 'AppController.php';
require_once __DIR__ . '/../SessionManager.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/AlbumRepository.php';
require_once __DIR__ . '/../repository/AuthorRepository.php';
require_once __DIR__ . '/../repository/CategoryRepository.php';
require_once __DIR__ . '/../repository/LanguageRepository.php';
require_once __DIR__ . '/../repository/ReviewRepository.php';

class AlbumDetailsController extends AppController
{

    private $userRepository;
    private $albumRepository;
    private $reviewRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->albumRepository = new AlbumRepository();
        $this->reviewRepository = new ReviewRepository();
    }

    public function albumDetails($albumId)
    {
        if (!$albumId) {
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

        $album = $this->albumRepository->getAlbumById($albumId, $userId);
        $reviews = $this->reviewRepository->getAlbumReviews($albumId);

        if (!$album) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: $url/dashboard");
        }

        print $this->render('/albumDetails', [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'avatar' => $user->getAvatar(),
            'isAdmin' => $user->getRole(),
            'album' => $album,
            'reviews' => $reviews]);
    }

    public function addReview()
    {
        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");

        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-Type: application/json');
            http_response_code(200);

            echo json_encode($this->reviewRepository->addAlbumReview((int)$userId, $decoded['albumId'], date("Y-m-d"), $decoded['reviewRate'], $decoded['reviewContent']));
        }
    }
}