<?php
session_start();

if (isset($_SESSION["user_id"])) {
    if (isset($_SESSION["role"]) && $_SESSION["role"] === "member") {
        header("Location: View/memberDashboard.php");
    } else {
        header("Location: View/dashboard.php");
    }
} else {
    header("Location: View/login.php");
}
exit;
?>
