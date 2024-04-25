<?php

class SessionManager {

    const SESSION_ACTIVE = true;
    const SESSION_INACTIVE = false;

    private $sessionState = self::SESSION_INACTIVE;

    private static $instance = null;

    private function __construct() {}

    private function startSession(): bool {
        if ($this->sessionState == self::SESSION_INACTIVE) {
            $this->sessionState = session_start();
        }

        return $this->sessionState;
    }

    public static function getInstance(): SessionManager {
        if(!self::$instance) {
            self::$instance = new self;
            self::$instance->startSession();
        }

        return self::$instance;
    }

    public function _set($name, $value) {
        $_SESSION[$name] = $value;
    }

    public function _get(string $name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    public function _isset($name): bool {
        return isset($_SESSION[$name]);
    }

    public function _unset(string $name) {
        unset($_SESSION[$name]);
    }

    public function destroySession(): bool {
        if ($this->sessionState == self::SESSION_ACTIVE) {
            $this->sessionState = session_destroy();
            unset($_SESSION);

            return $this->sessionState;
        }

        return false;
    }

}