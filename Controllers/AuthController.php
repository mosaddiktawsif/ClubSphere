<?php

session_start();
require_once __DIR__ . '/../Controllers/database.php';
require_once __DIR__ . '/../Model/User.php';

$database = new Database();
$db = $database->connect();
$user = new User($db);

$action = $_POST["action"] ?? "";

if ($action == "register") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    if ($password !== $confirmPassword) {
        header("Location: ../View/register.php?error=password_mismatch");
        exit;
    }

    if ($user->usernameExists($username)) {
        header("Location: ../View/register.php?error=username_taken");
        exit;
    }

    if ($user->register($username, $email, $password)) {
        header("Location: ../View/login.php?success=registered");
    } else {
        header("Location: ../View/register.php?error=failed");
    }
    exit;

} elseif ($action == "login") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if ($user->login($username, $password)) {

        if ($user->status == "pending") {
            header("Location: ../View/login.php?error=pending");
            exit;
        }
        if ($user->status == "rejected") {
            header("Location: ../View/login.php?error=rejected");
            exit;
        }

        $_SESSION["user_id"] = $user->id;
        $_SESSION["username"] = $user->username;
        $_SESSION["role"] = $user->role;
        header("Location: ../View/dashboard.php");
    } else {
        header("Location: ../View/login.php?error=invalid");
    }
    exit;
}

header("Location: ../View/login.php");
exit;
?>
