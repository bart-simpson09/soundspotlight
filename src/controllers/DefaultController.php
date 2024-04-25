<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function index() {
        print $this->render('login');
    }
    
    public function dashboard() {
        print $this->render('dashboard');
    }
}