<?php

require_once 'AppController.php';
require_once __DIR__ . '/../SessionManager.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class DashboardController extends AppController
{

    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function dashboard()
    {

        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");
        $userEmail = $userSession->__get("userEmail");

        $user = $this->userRepository->getUser($userEmail);

        if ($userId == null) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: $url/login");
        }


        print $this->render('/dashboard', ['firstName' => $user->getFirstName(), 'lastName' => $user->getLastName(), 'avatar' => $user->getAvatar(), 'isAdmin' => $user->getRole()]);
    }
}