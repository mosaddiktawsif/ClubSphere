<?php

class Tournament {

    private $conn;
    private $table = "tournaments";

    function __construct($db) {
        $this->conn = $db;
    }

    function createTournament($title, $gameType, $startDate, $endDate, $prizePool, $region, $createdBy) {
        $query = "INSERT INTO " . $this->table . "
                  (title, game_type, start_date, end_date, prize_pool, region, status, created_by)
                  VALUES (:title, :game_type, :start_date, :end_date, :prize_pool, :region, 'upcoming', :created_by)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":game_type", $gameType);
        $stmt->bindParam(":start_date", $startDate);
        $stmt->bindParam(":end_date", $endDate);
        $stmt->bindParam(":prize_pool", $prizePool);
        $stmt->bindParam(":region", $region);
        $stmt->bindParam(":created_by", $createdBy);
        return $stmt->execute();
    }

    function getAllTournaments() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY start_date ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
