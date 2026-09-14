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
$userProfile = $user->getProfile($_SESSION["user_id"]) ?: ['gaming_preferences' => '', 'in_game_rankings' => '', 'social_media_links' => ''];

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

        <?php if ($userData["role"] === 'member'): ?>
            <label>Gaming Preferences (e.g., FPS, MOBA)</label>
            <input type="text" name="gaming_preferences" value="<?php echo htmlspecialchars($userProfile["gaming_preferences"]); ?>">

            <label>In-game Rankings (e.g., Valorant: Diamond, CSGO: LEM)</label>
            <input type="text" name="in_game_rankings" value="<?php echo htmlspecialchars($userProfile["in_game_rankings"]); ?>">

            <label>Social Media Links (Twitter, Discord, etc.)</label>
            <input type="text" name="social_media_links" value="<?php echo htmlspecialchars($userProfile["social_media_links"]); ?>">
        <?php endif; ?>

        <button type="submit">Save Changes</button>
    </form>

    <form action="../Controllers/ProfileController.php" method="POST" onsubmit="return confirm('Delete your account permanently?');">
        <input type="hidden" name="action" value="delete_account">
        <button type="submit" class="danger">Delete Account</button>
    </form>

    <p>
        <?php if ($userData["role"] === 'member'): ?>
            <a href="memberDashboard.php">Back to Dashboard</a>
        <?php else: ?>
            <a href="dashboard.php">Back to Dashboard</a>
        <?php endif; ?>
    </p>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
