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
Router::get('myProfile', 'MyProfileController');
Router::get('adminConsole', 'AdminConsoleController');

Router::post('login', 'SecurityController');
Router::post('logout', 'SecurityController');
Router::post('searchAlbum', 'DashboardController');
Router::post('addAlbum', 'AddAlbumController');
Router::post('changePhoto', 'MyProfileController');
Router::post('addReview', 'AlbumDetailsController');
Router::post('toggleFavorite', 'YourFavoritesController');
Router::post('changeReviewStatus', 'AdminConsoleController');
Router::post('changeAlbumStatus', 'AdminConsoleController');
Router::post('manageUser', 'AdminConsoleController');

Router::run($path);