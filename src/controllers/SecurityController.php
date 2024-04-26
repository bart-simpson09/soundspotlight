<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../SessionManager.php';

class SecurityController extends AppController
{

    public function redirectBasedOnSession()
    {
        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");
        $url = "http://$_SERVER[HTTP_HOST]";

        if ($userId == null) {
            header("Location: $url/login");
        } else {
            header("Location: $url/dashboard");
        }
        exit();
    }

    public function login()
    {

        $user = new User('1', 'sajdak@example.com', '123', 'Mateusz', 'Sajdak', 'avatar-src', 'default');

        if (!$this->isPost()) {
            print $this->render('/login');
            return;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($user->getEmail() !== $email) {
            print $this->render('/login', ['messages' => ['User with this email address does not exist!']]);
            return;
        }

        if ($user->getPassword() !== $password) {
            print $this->render('/login', ['messages' => ['Wrong password!']]);
            return;
        }

        $userSession = SessionManager::getInstance();
        $userSession->__set('userId', $user->getId());
        $userSession->__set('userEmail', $user->getEmail());

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: $url/dashboard");
    }

    public function logout()
    {
        $userSession = SessionManager::getInstance();
        $userSession->destroySession();

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: $url/");
    }
}