<?php
require_once __DIR__ . '/../Controllers/constants.php';

function requireLogin() {
    if (!isset($_SESSION["user_id"])) {
        header("Location: " . BASE_URL . "/View/login.php");
        exit;
    }
}

function requireRole($role) {
    requireLogin();
    if ($_SESSION["role"] !== $role) {
        header("Location: " . BASE_URL . "/View/dashboard.php?error=unauthorized");
        exit;
    }
}
?>
