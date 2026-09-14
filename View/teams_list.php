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
require_once __DIR__ . '/../Model/TeamModel.php';

$database = new Database();
$db = $database->connect();
$user = new User($db);
$userData = $user->findById($_SESSION["user_id"]);

$teamModel = new TeamModel($db);
$teams = $teamModel->getAllTeams();

include __DIR__ . '/partials/header.php';
?>

<style>
.teams-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 30px;
    margin-top: 30px;
    text-align: center;
}
.team-item {
    background: #fff;
    padding: 20px 10px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    cursor: pointer;
    transition: transform 0.2s;
}
.team-item:hover {
    transform: translateY(-5px);
}
.team-logo {
    width: 60px;
    height: 60px;
    object-fit: contain;
    margin-bottom: 15px;
}
.team-name {
    font-weight: 600;
    color: var(--navy);
    font-size: 14px;
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
            <a href="teams_list.php" class="active">Club Teams</a>
            <a href="member_tournaments.php">Tournaments</a>
            <a href="edit_profile.php">User Profile</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>

    <div class="admin-main">
        <div class="card wide" style="background: transparent; box-shadow: none;">
            <h2 style="text-align: center; font-size: 28px; font-weight: 400;">Registered Teams</h2>
            
            <?php if (isset($_GET["success"]) && $_GET["success"] == "applied"): ?>
                <p class="msg success">Successfully applied to join the team. Waiting for captain's approval.</p>
            <?php endif; ?>
            <?php if (isset($_GET["error"]) && $_GET["error"] == "already_applied"): ?>
                <p class="msg error">You have already applied to this team.</p>
            <?php endif; ?>

            <div class="teams-grid">
                <?php if (empty($teams)): ?>
                    <p style="grid-column: 1 / -1; text-align: center; color: var(--muted);">No teams found.</p>
                <?php else: ?>
                    <?php foreach ($teams as $team): ?>
                        <?php $status = $teamModel->getApplicationStatus($_SESSION["user_id"], $team["id"]); ?>
                        <div class="team-item">
                            <div style="font-size: 40px; margin-bottom: 10px;">🛡️</div>
                            <div class="team-name" style="margin-bottom: 10px;"><?php echo htmlspecialchars($team["name"]); ?></div>
                            
                            <?php if ($status === 'pending'): ?>
                                <span class="badge upcoming">Pending</span>
                            <?php elseif ($status === 'accepted'): ?>
                                <span class="badge ongoing">Member</span>
                            <?php else: ?>
                                <form action="../Controllers/TeamActionController.php" method="POST" style="margin:0;">
                                    <input type="hidden" name="action" value="apply_team">
                                    <input type="hidden" name="team_id" value="<?php echo $team["id"]; ?>">
                                    <button type="submit" style="margin-top:5px; padding: 6px; font-size: 12px; background-color: var(--blue);">Apply to Join</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
