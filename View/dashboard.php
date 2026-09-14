<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../Controllers/database.php';
require_once __DIR__ . '/../Model/User.php';

$database = new Database();
$db = $database->connect();
$user = new User($db);
$userData = $user->findById($_SESSION["user_id"]);

include __DIR__ . '/partials/header.php';
?>

<div class="card">
    <h2>Hello, <?php echo htmlspecialchars($userData["username"]); ?></h2>
    <p>Role: <?php echo htmlspecialchars(ucfirst($userData["role"])); ?></p>
    <p>Email: <?php echo htmlspecialchars($userData["email"]); ?></p>
    <p>Joined: <?php echo htmlspecialchars($userData["joined_date"]); ?></p>

    <div class="dash-links">
        <a href="edit_profile.php">Edit Profile</a>
        <?php if ($userData["role"] == "admin"): ?>
            <a href="admin/panel.php">Admin Panel</a>
        <?php endif; ?>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
