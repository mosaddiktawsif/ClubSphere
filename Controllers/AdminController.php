<?php

session_start();
require_once __DIR__ . '/../Controllers/auth_guard.php';
require_once __DIR__ . '/../Controllers/database.php';
require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../Model/ClubFund.php';
require_once __DIR__ . '/../Model/Tournament.php';

requireRole('admin');

$database = new Database();
$db = $database->connect();

$action = $_POST["action"] ?? "";

if ($action == "approve_user") {

    $user = new User($db);
    $user->approveUser($_POST["user_id"], $_POST["role"]);
    header("Location: " . BASE_URL . "/View/admin/members.php?success=approved");
    exit;

} elseif ($action == "reject_user") {

    $user = new User($db);
    $user->rejectUser($_POST["user_id"]);
    header("Location: " . BASE_URL . "/View/admin/members.php?success=rejected");
    exit;

} elseif ($action == "update_role") {

    $user = new User($db);
    $user->updateRole($_POST["user_id"], $_POST["role"]);
    header("Location: " . BASE_URL . "/View/admin/members.php?success=role_updated");
    exit;

} elseif ($action == "add_transaction") {

    $fund = new ClubFund($db);
    $fund->addTransaction($_POST["type"], $_POST["description"], $_POST["amount"], $_SESSION["user_id"]);
    header("Location: " . BASE_URL . "/View/admin/fund.php?success=added");
    exit;

} elseif ($action == "create_tournament") {

    $tournament = new Tournament($db);
    $tournament->createTournament(
        $_POST["title"],
        $_POST["game_type"],
        $_POST["start_date"],
        $_POST["end_date"],
        $_POST["prize_pool"],
        $_POST["region"],
        $_SESSION["user_id"]
    );
    header("Location: " . BASE_URL . "/View/admin/tournaments.php?success=created");
    exit;

} elseif ($action == "update_tournament_status") {

    $tournament = new Tournament($db);
    $tournament->updateStatus($_POST["tournament_id"], $_POST["status"]);
    header("Location: " . BASE_URL . "/View/admin/tournaments.php?success=updated");
    exit;
}

header("Location: " . BASE_URL . "/View/admin/panel.php");
exit;
?>
