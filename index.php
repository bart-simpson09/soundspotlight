<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('register', 'DefaultController');
Router::get('dashboard', 'DefaultController');
Router::get('addAlbum', 'DefaultController');
Router::get('adminConsole', 'DefaultController');
Router::get('albumDetails', 'DefaultController');
Router::get('myProfile', 'DefaultController');
Router::get('topAlbums', 'DefaultController');
Router::get('yourFavorite', 'DefaultController');

Router::run($path);