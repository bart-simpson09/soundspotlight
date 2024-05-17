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
            $user['firstname'],
            $user['lastname'],
            $user['avatar'],
            $user['role']);
    }

    public function getAllUsers(): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users ORDER BY id
        ');
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $users;
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

    public function changePhoto(int $userId, string $newPhoto)
    {
        $stmt = $this->database->connect()->prepare('
        UPDATE users SET avatar = :newPhoto WHERE id = :userId
    ');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':newPhoto', $newPhoto, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function changeUserRole(int $userId, string $action)
    {
        $newRole = $action === "removeAdmin" ? "user" : ($action === "addAdmin" ? "admin" : null);

        if ($newRole) {
            $stmt = $this->database->connect()->prepare('
        UPDATE users SET role = :role WHERE id = :userId');
            $stmt->bindParam(':role', $newRole, PDO::PARAM_STR);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    public function deleteUser(int $userId)
    {
        $stmt = $this->database->connect()->prepare('
    DELETE FROM users WHERE id = :userId');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

}