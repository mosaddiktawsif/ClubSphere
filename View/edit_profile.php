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
    <h2>Edit Profile</h2>

    <?php if (isset($_GET["success"])): ?>
        <p class="msg success">Profile updated successfully.</p>
    <?php endif; ?>

    <?php if (isset($_GET["error"])): ?>
        <p class="msg error">Update failed. Please try again.</p>
    <?php endif; ?>

    <form action="../Controllers/ProfileController.php" method="POST">
        <input type="hidden" name="action" value="update_profile">

        <label>Username</label>
        <input type="text" value="<?php echo htmlspecialchars($userData["username"]); ?>" disabled>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($userData["email"]); ?>" required>

        <button type="submit">Save Changes</button>
    </form>

    <form action="../Controllers/ProfileController.php" method="POST" onsubmit="return confirm('Delete your account permanently?');">
        <input type="hidden" name="action" value="delete_account">
        <button type="submit" class="danger">Delete Account</button>
    </form>

    <p><a href="dashboard.php">Back to Dashboard</a></p>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
