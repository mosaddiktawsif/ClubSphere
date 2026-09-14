<?php

class ClubFund {

    private $conn;
    private $table = "club_fund";

    function __construct($db) {
        $this->conn = $db;
    }

    function addTransaction($type, $description, $amount, $createdBy) {
        $query = "INSERT INTO " . $this->table . " (type, description, amount, transaction_date, created_by)
                  VALUES (:type, :description, :amount, NOW(), :created_by)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":type", $type);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":amount", $amount);
        $stmt->bindParam(":created_by", $createdBy);
        return $stmt->execute();
    }

    function getAllTransactions() {
        $query = "SELECT cf.*, u.username AS logged_by
                  FROM " . $this->table . " cf
                  LEFT JOIN users u ON cf.created_by = u.id
                  ORDER BY cf.transaction_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getBalance() {
        $query = "SELECT
                    COALESCE(SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END), 0) AS total_income,
                    COALESCE(SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END), 0) AS total_expense
                  FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["total_income"] - $row["total_expense"];
    }
}
?>
