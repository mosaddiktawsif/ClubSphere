<?php

class Database {

    private $host = "localhost";
    private $dbname = "clubsphere_db";
    private $username = "root";
    private $password = "";
    public $conn;

    function connect() {

        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection Error: " . $e->getMessage());
        }

        return $this->conn;
    }
}
?>
