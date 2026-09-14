<?php
class CaptainModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registerCaptain($name, $phone, $email, $ign, $game, $password) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO captains (real_name, phone, email, ign, game, password) VALUES (:name, :phone, :email, :ign, :game, :password)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":ign", $ign);
        $stmt->bindParam(":game", $game);
        $stmt->bindParam(":password", $hashed);
        return $stmt->execute();
    }

    public function getCaptainByEmail($email) {
        $query = "SELECT * FROM captains WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addRosterMember($captain_id, $real_name, $ign, $phone) {
        $query = "INSERT INTO rosters (captain_id, real_name, ign, phone) VALUES (:captain_id, :real_name, :ign, :phone)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":captain_id", $captain_id);
        $stmt->bindParam(":real_name", $real_name);
        $stmt->bindParam(":ign", $ign);
        $stmt->bindParam(":phone", $phone);
        return $stmt->execute();
    }

    public function updateRosterMember($member_id, $captain_id, $real_name, $ign, $phone) {
        $query = "UPDATE rosters SET real_name = :real_name, ign = :ign, phone = :phone WHERE id = :member_id AND captain_id = :captain_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":real_name", $real_name);
        $stmt->bindParam(":ign", $ign);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":member_id", $member_id);
        $stmt->bindParam(":captain_id", $captain_id);
        return $stmt->execute();
    }

    public function deleteRosterMember($member_id, $captain_id) {
        $query = "DELETE FROM rosters WHERE id = :member_id AND captain_id = :captain_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":member_id", $member_id);
        $stmt->bindParam(":captain_id", $captain_id);
        return $stmt->execute();
    }

    public function getTeamRoster($captain_id) {
        $query = "SELECT * FROM rosters WHERE captain_id = :captain_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":captain_id", $captain_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registerForTournament($captain_id, $tournament_id) {
        $query = "INSERT INTO tournament_registrations (captain_id, tournament_id) VALUES (:captain_id, :tournament_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":captain_id", $captain_id);
        $stmt->bindParam(":tournament_id", $tournament_id);
        return $stmt->execute();
    }

    public function submitScoreProof($captain_id, $tournament_id, $score, $proof_image) {
        $query = "INSERT INTO match_scores (captain_id, tournament_id, score, proof_image) VALUES (:captain_id, :tournament_id, :score, :proof_image)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":captain_id", $captain_id);
        $stmt->bindParam(":tournament_id", $tournament_id);
        $stmt->bindParam(":score", $score);
        $stmt->bindParam(":proof_image", $proof_image);
        return $stmt->execute();
    }
}
?>