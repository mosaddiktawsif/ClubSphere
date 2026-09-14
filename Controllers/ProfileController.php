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

    if ($user->updateProfile($_SESSION["user_id"], $email)) {
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
