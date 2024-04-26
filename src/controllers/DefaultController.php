<?php

require_once 'AppController.php';
require_once __DIR__ .'/../SessionManager.php';

class DefaultController extends AppController {

    public function index() {

        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");
        $url = "http://$_SERVER[HTTP_HOST]";

        if ($userId == null) {
            header("Location: $url/login");
        }

        header("Location: $url/dashboard");
    }
}