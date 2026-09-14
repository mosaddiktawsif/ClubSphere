<?php
session_start();
require_once __DIR__ . '/../Controllers/database.php';
require_once __DIR__ . '/../Model/TeamModel.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ../View/login.php");
    exit;
}

$database = new Database();
$db = $database->connect();
$teamModel = new TeamModel($db);

$action = $_POST["action"] ?? "";

if ($action == "apply_team") {
    $teamId = $_POST["team_id"] ?? null;
    $userId = $_SESSION["user_id"];

    if ($teamId) {
        // check if already applied
        $status = $teamModel->getApplicationStatus($userId, $teamId);
        
        if ($status === null) {
            if ($teamModel->applyToTeam($userId, $teamId)) {
                header("Location: ../View/teams_list.php?success=applied");
                exit;
            }
        } else {
            header("Location: ../View/teams_list.php?error=already_applied");
            exit;
        }
    }
}

header("Location: ../View/teams_list.php?error=failed");
exit;
?>
