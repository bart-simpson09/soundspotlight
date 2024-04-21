<?php

class User {
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $avatar;

    public function __construct(string $firstName, string $lastName, string $email, string $password, string $avatar) {
        $this->firsName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->avatar = $avatar;
    }

    public function getFirstName():string {
        return $this->firstName;
    }

    public function setFirstName(string $firstName) {
        $this->firstName = $firstName;
    }

    public function getLastName():string {
        return $this->lastName;
    }

    public function setLastName(string $lastName) {
        $this->lastName = $lastName;
    }

    public function getEmail():string {
        return $this->email;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }

    public function getPassword():string {
        return $this->password;
    }

    public function setPassword(string $password) {
        $this->password = $password;
    }

    public function getAvatar():string {
        return $this->avatar;
    }

    public function setAvatar(string $avatar) {
        $this->avatar = $avatar;
    }
}