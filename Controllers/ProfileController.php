<?php

session_start();
require_once __DIR__ . '/../Controllers/database.php';
require_once __DIR__ . '/../Model/User.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: ../View/login.php");
    exit;
}

$database = new Database();
$db = $database->connect();
$user = new User($db);

$action = $_POST["action"] ?? "";

if ($action == "update_profile") {

    $email = trim($_POST["email"]);
    $gaming_preferences = trim($_POST["gaming_preferences"] ?? "");
    $in_game_rankings = trim($_POST["in_game_rankings"] ?? "");
    $social_media_links = trim($_POST["social_media_links"] ?? "");

    $success = $user->updateProfile($_SESSION["user_id"], $email);

    if ($success && isset($_POST["gaming_preferences"])) {
        $user->updateGamingProfile($_SESSION["user_id"], $gaming_preferences, $in_game_rankings, $social_media_links);
    }

    if ($success) {
        header("Location: ../View/edit_profile.php?success=updated");
    } else {
        header("Location: ../View/edit_profile.php?error=failed");
    }
    exit;

} elseif ($action == "delete_account") {

    if ($user->deleteAccount($_SESSION["user_id"])) {
        $_SESSION = [];
        session_destroy();
        header("Location: ../View/login.php?success=deleted");
        exit;
    }
}

header("Location: ../View/dashboard.php");
exit;   
?>
