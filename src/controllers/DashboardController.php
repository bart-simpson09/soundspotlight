<?php

require_once 'AppController.php';
require_once __DIR__ .'/../SessionManager.php';

class DashboardController extends AppController {

    public function __construct() {
        parent::__construct();
    }

    public function dashboard() {

        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");

        if ($userId == null) {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: $url/login");
        }

        print $this->render('dashboard');
    }
}