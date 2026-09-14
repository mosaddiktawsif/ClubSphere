<?php

class TeamModel {
    private $conn;
    private $table = "teams";

    function __construct($db) {
        $this->conn = $db;
    }

    function getAllTeams() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function getTeamById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function applyToTeam($userId, $teamId) {
        $query = "INSERT INTO team_applications (team_id, user_id, status, applied_at) VALUES (:team_id, :user_id, 'pending', NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":team_id", $teamId);
        $stmt->bindParam(":user_id", $userId);
        return $stmt->execute();
    }

    function getApplicationStatus($userId, $teamId) {
        $query = "SELECT status FROM team_applications WHERE user_id = :user_id AND team_id = :team_id ORDER BY applied_at DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":team_id", $teamId);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['status'] : null;
    }

    function getUserTeam($userId) {
        $query = "SELECT t.* FROM teams t 
                  JOIN team_applications ta ON t.id = ta.team_id 
                  WHERE ta.user_id = :user_id AND ta.status = 'accepted' LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
