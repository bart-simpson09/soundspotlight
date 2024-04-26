<?php

class User
{
    private $id;
    private $email;
    private $password;
    private $firstName;
    private $lastName;
    private $avatar;
    private $role;

    public function __construct(?int $id, string $email, string $password, ?string $firstName, ?string $lastName, ?string $avatar, ?string $role)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->avatar = $avatar;
        $this->role = $role;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function getRole(): string
    {
        return $this->role;
    }
}