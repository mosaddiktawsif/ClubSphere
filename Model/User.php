<?php

class User {

    public $id;
    public $username;
    public $email;
    public $role;
    public $status;

    private $conn;
    private $table = "users";

    function __construct($db) {
        $this->conn = $db;
    }

    function usernameExists($username) {
        $query = "SELECT id FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    function register($username, $email, $password) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    
        $query = "INSERT INTO " . $this->table . " (username, email, password_hash, role, status, joined_date)
                  VALUES (:username, :email, :password, 'member', 'pending', NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashedPassword);

        return $stmt->execute();
    }

    function login($username, $password) {

        $query = "SELECT * FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userRow && password_verify($password, $userRow["password_hash"])) {
            $this->id = $userRow["id"];
            $this->username = $userRow["username"];
            $this->email = $userRow["email"];
            $this->role = $userRow["role"];
            $this->status = $userRow["status"];
            return true;
        }

        return false;
    }

    function findById($id) {
        $query = "SELECT id, username, email, role, status, joined_date FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function updateProfile($id, $email) {
        $query = "UPDATE " . $this->table . " SET email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    function deleteAccount($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    

    function getPendingUsers() {
        $query = "SELECT id, username, email, joined_date FROM " . $this->table . " WHERE status = 'pending' ORDER BY joined_date ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getAllApprovedUsers() {
        $query = "SELECT id, username, email, role, joined_date FROM " . $this->table . " WHERE status = 'approved' ORDER BY username ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function approveUser($id, $role) {
        $query = "UPDATE " . $this->table . " SET status = 'approved', role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    function rejectUser($id) {
        $query = "UPDATE " . $this->table . " SET status = 'rejected' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    function updateRole($id, $role) {
        $query = "UPDATE " . $this->table . " SET role = :role WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    function countApprovedMembers() {
        $query = "SELECT COUNT(*) AS total FROM " . $this->table . " WHERE status = 'approved'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)["total"];
    }
}
?>
