<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function index() {
        $this->render('login');
    }

    public function register() {
        $this->render('register');
    }
    
    public function dashboard() {
        $this->render('dashboard');
    }

    public function addAlbum() {
        $this->render('addAlbum');
    }

    public function adminConsole() {
        $this->render('adminConsole');
    }

    public function albumDetails() {
        $this->render('albumDetails');
    }

    public function myProfile() {
        $this->render('myProfile');
    }

    public function topAlbums() {
        $this->render('topAlbums');
    }

    public function yourFavorite() {
        $this->render('yourFavorite');
    }
}