<?php
include "Database.php";
class User
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createUser($name, $email)
    {
        $query = "INSERT INTO users (name, email) VALUES (:name, :email)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    public function getUserById($id)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUserEmail($id, $newEmail)
    {
        $query = "UPDATE users SET email = :email WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':email', $newEmail);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteUser($id)
    {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

// Usage:
$db = new Database();
$user = new User($db->pdo);

// 1.create
// $user->createUser("Jane Doe", "jane@example.com");

// 2. Read
// $userData = $user->getUserById(5);
// print_r($userData);
/*
*/

// 3. Update
// $user->updateUserEmail(8, "talha@example.com");

// 4.Delete

$user->deleteUser(8);
echo "Deleted Successfuly";
