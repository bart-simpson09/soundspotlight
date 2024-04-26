<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users WHERE email = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return new User(
            $user['id'],
            $user['email'],
            $user['password'],
            $user['firstName'],
            $user['lastName'],
            $user['avatar'],
            $user['role']);
    }

    public function addUser(User $newUser)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO users (email, password, firstName, lastName) VALUES (?, ?, ?, ?)
        ');
        $stmt->execute([
            $newUser->getEmail(), $newUser->getPassword(), $newUser->getFirstName(), $newUser->getLastName()
        ]);

    }

}