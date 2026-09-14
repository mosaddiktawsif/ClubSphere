<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["role"] !== "member") {
    header("Location: dashboard.php");
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

<div class="admin-layout">
    <div class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-badge">AEC</div>
            <div>
                <div class="sidebar-title">ClubSphere</div>
                <div class="sidebar-subtitle">Hello, User</div>
            </div>
        </div>
        <div class="sidebar-nav">
            <a href="memberDashboard.php" class="active">Dashboard</a>
            <a href="teams_list.php">Club Teams</a>
            <a href="#">Tournaments</a>
            <a href="#">Events</a>
            <a href="#">Notification <span class="text-red">•</span></a>
            <a href="#">Reports</a>
            <a href="edit_profile.php">User Profile</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>

    <div class="admin-main">
        <div class="admin-stats">
            <div class="stat-box">
                <div class="stat-icon purple">
                    <!-- Icon placeholder -->
                    Rx
                </div>
                <div>
                    <div class="stat-label">PRX</div>
                    <div class="stat-value">W W D L</div>
                </div>
            </div>
            
            <div class="stat-box">
                <div class="stat-icon blue">
                    <!-- Icon placeholder -->
                    🏆
                </div>
                <div>
                    <div class="stat-label">Wins</div>
                    <div class="stat-value">4</div>
                </div>
            </div>
            
            <div class="stat-box">
                <div class="stat-icon green">
                    <!-- Icon placeholder -->
                    V
                </div>
                <div>
                    <div class="stat-label">Champion</div>
                    <div class="stat-value">V</div>
                </div>
            </div>
        </div>

        <div class="card wide">
            <h2>Upcoming Events</h2>
            <div style="border: 1px solid #e6e9f2; border-radius: 8px; padding: 40px; text-align: center; color: var(--muted);">
                There is no upcoming event currently
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
