<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../SessionManager.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class SecurityController extends AppController
{
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function redirectBasedOnSession()
    {
        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");
        $url = "http://{$_SERVER['HTTP_HOST']}";

        if ($userId === null) {
            $this->redirectToLogin();
        } else {
            $this->redirectToDashboard();
        }
    }

    private function redirectToLogin()
    {
        $url = "http://{$_SERVER['HTTP_HOST']}/login";
        header("Location: $url");
        exit();
    }

    private function redirectToDashboard()
    {
        $url = "http://{$_SERVER['HTTP_HOST']}/dashboard";
        header("Location: $url");
        exit();
    }

    public function login()
    {
        if (!$this->isPost()) {
            print $this->render('/login');
            return;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userRepository->getUser($email);

        if (!$user) {
            print $this->render('/login', ['messages' => ['User with this email address does not exist!']]);
            return;
        }

        if (!password_verify($password, $user->getPassword())) {
            print $this->render('/login', ['messages' => ['Wrong password!']]);
            return;
        }

        $userSession = SessionManager::getInstance();
        $userSession->__set('userId', $user->getId());
        $userSession->__set('userEmail', $user->getEmail());

        $this->redirectToDashboard();
    }

    public function logout()
    {
        $userSession = SessionManager::getInstance();
        $userSession->destroySession();

        $this->redirectToLogin();
    }

    public function register()
    {
        if (!$this->isPost()) {
            print $this->render('/register');
            return;
        }

        $handledErrors = [];

        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repeatedPassword = $_POST['repeatedPassword'];

        $this->validateRegisterForm($firstName, $lastName, $email, $password, $repeatedPassword, $handledErrors);

        $user = $this->userRepository->getUser($email);

        if ($user !== null && $email === $user->getEmail()) {
            $handledErrors['userExists'] = "User with this email address already exists";
        }

        if (!empty($handledErrors)) {
            print $this->render('/register', ['messages' => $handledErrors]);
            return;
        }

        $addUser = new User(null, $email, password_hash($password, PASSWORD_BCRYPT), $firstName, $lastName, null, null);
        $this->userRepository->addUser($addUser);

        $user = $this->userRepository->getUser($email);
        $userSession = SessionManager::getInstance();
        $userSession->__set('userId', $user->getId());
        $userSession->__set('userEmail', $user->getEmail());

        $this->redirectToLogin();
    }

    private function validateRegisterForm($firstName, $lastName, $email, $password, $repeatedPassword, &$handledErrors)
    {
        if (empty($firstName)) {
            $handledErrors['firstName'] = "First name is required";
        }

        if (empty($lastName)) {
            $handledErrors['lastName'] = "Last name is required";
        }

        if (empty($email)) {
            $handledErrors['email'] = "Email address is required";
        }

        if (empty($password)) {
            $handledErrors['password'] = "Password is required";
        }

        if (empty($repeatedPassword)) {
            $handledErrors['repeatedPassword'] = "Type your password again";
        }

        if ($password !== $repeatedPassword) {
            $handledErrors['repeatedPassword'] = "Repeated password does not match";
        }
    }
}
