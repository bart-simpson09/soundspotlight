<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'SecurityController');
Router::post('login', 'SecurityController');
Router::get('dashboard', 'DashboardController');

Router::run($path);