<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/User.php';

class SecurityController extends AppController {

    public function login()
    {   
        $user = new User('Mateusz', 'Sajdak', 'sajdak@example.com', '123', 'avatar-src');

        if (!$this->isPost()) {
            print $this->render('/login');
            return;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($user->getEmail() !== $email) {
            print $this->render('/login', ['messages' => ['Wrong email address!']]);
            return;
        }

        if ($user->getPassword() !== $password) {
            print $this->render('/login', ['messages' => ['Wrong password!']]);
            return;
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: $url/dashboard");
    }
}