<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'SecurityController');
Router::get('register', 'SecurityController');
Router::get('dashboard', 'DashboardController');
Router::get('addAlbum', 'AddAlbumController');
Router::get('albumDetails', 'AlbumDetailsController');
Router::get('topAlbums', 'TopAlbumsController');
Router::get('yourFavorites', 'YourFavoritesController');

Router::post('login', 'SecurityController');
Router::post('logout', 'SecurityController');
Router::post('searchAlbum', 'DashboardController');
Router::post('addAlbum', 'AddAlbumController');

Router::run($path);