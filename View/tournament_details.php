<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../Controllers/database.php';
require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../Model/Tournament.php';

if (!isset($_GET["id"])) {
    header("Location: member_tournaments.php");
    exit;
}

$database = new Database();
$db = $database->connect();
$user = new User($db);
$userData = $user->findById($_SESSION["user_id"]);

$stmt = $db->prepare("SELECT * FROM tournaments WHERE id = :id LIMIT 1");
$stmt->bindParam(":id", $_GET["id"]);
$stmt->execute();
$tournament = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tournament) {
    header("Location: member_tournaments.php");
    exit;
}

include __DIR__ . '/partials/header.php';
?>

<style>
.t-details-card {
    background: #2a345c;
    color: #fff;
    padding: 30px;
    border-radius: 12px;
}
.t-header {
    margin-bottom: 20px;
}
.t-header h2 {
    margin: 0 0 10px 0;
    font-size: 24px;
    color: #fff;
}
.t-header p {
    color: #a5b4fc;
    font-size: 14px;
    margin: 0;
}
.t-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 20px;
    background: rgba(0,0,0,0.15);
    padding: 20px;
    border-radius: 8px;
}
.info-row {
    display: flex;
    gap: 10px;
    align-items: center;
    font-size: 14px;
}
.info-label {
    color: #a5b4fc;
    width: 80px;
}
</style>

<div class="admin-layout">
    <div class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-badge">AEC</div>
            <div>
                <div class="sidebar-title">ClubSphere</div>
                <div class="sidebar-subtitle">Hello, <?php echo htmlspecialchars($userData["username"]); ?></div>
            </div>
        </div>
        <div class="sidebar-nav">
            <a href="memberDashboard.php">Dashboard</a>
            <a href="teams_list.php">Club Teams</a>
            <a href="member_tournaments.php" class="active">Tournaments</a>
            <a href="edit_profile.php">User Profile</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>

    <div class="admin-main">
        <div class="t-details-card">
            <div class="t-header">
                <h2><?php echo htmlspecialchars($tournament["title"]); ?></h2>
                <p>Join the ultimate <?php echo htmlspecialchars($tournament["game_type"]); ?> tournament and compete with top players. Exciting rewards await!</p>
            </div>
            
            <div class="t-info-grid">
                <div class="info-row">
                    <span class="info-label">🎮 Game</span>
                    <span><?php echo htmlspecialchars($tournament["game_type"]); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">📅 Dates</span>
                    <span><?php echo date('M j', strtotime($tournament["start_date"])) . ' - ' . date('M j, Y', strtotime($tournament["end_date"])); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">💰 Prize</span>
                    <span>$<?php echo htmlspecialchars($tournament["prize_pool"]); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">🌍 Region</span>
                    <span><?php echo htmlspecialchars($tournament["region"]); ?></span>
                </div>
            </div>

            <div style="margin-top: 30px;">
                <h3 style="font-size: 18px; margin-bottom: 15px;">Live Bracket (Read Only)</h3>
                <div style="background: rgba(0,0,0,0.1); border: 1px dashed rgba(255,255,255,0.2); padding: 40px; text-align: center; border-radius: 8px; color: #a5b4fc;">
                    Bracket generating / No matches scheduled yet
                </div>
            </div>
            
            <div style="margin-top: 30px; text-align: right;">
                <a href="member_tournaments.php" style="color: #a5b4fc; text-decoration: none; font-size: 14px;">&larr; Back to Tournaments</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
