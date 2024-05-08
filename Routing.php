<?php

require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/DashboardController.php';
require_once 'src/controllers/AddAlbumController.php';
require_once 'src/controllers/AlbumDetailsController.php';

class Router
{

    public static $routes;

    public static function get($url, $view)
    {
        self::$routes[$url] = $view;
    }

    public static function post($url, $view)
    {
        self::$routes[$url] = $view;
    }

    public static function run($url)
    {
        $action = explode("/", $url)[0];
        if (!array_key_exists($action, self::$routes)) {
            die("Wrong url!");
        }

        $userSession = SessionManager::getInstance();
        $userId = $userSession->__get("userId");
        $publicPages = ['login', 'register'];

        if (!$userId && !in_array($action, $publicPages)) {
            header("Location: /login");
            exit();
        } else if ($userId && in_array($action, $publicPages)) {
            header("Location: /dashboard");
            exit();
        }

        $controller = self::$routes[$action];
        $object = new $controller;
        $action = $action ?: 'redirectBasedOnSession';
        $object->$action();
    }
}