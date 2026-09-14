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
require_once __DIR__ . '/../Model/Tournament.php';

$database = new Database();
$db = $database->connect();
$user = new User($db);
$userData = $user->findById($_SESSION["user_id"]);

$teamModel = new TeamModel($db);
$myTeam = $teamModel->getUserTeam($_SESSION["user_id"]);

$tourneyModel = new Tournament($db);
$upcomingTournaments = $tourneyModel->getUpcomingTournaments();

include __DIR__ . '/partials/header.php';
?>

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
            <a href="memberDashboard.php" class="active">Dashboard</a>
            <a href="teams_list.php">Club Teams</a>
            <a href="member_tournaments.php">Tournaments</a>
            <a href="edit_profile.php">User Profile</a>
            <a href="../logout.php">Logout</a>
        </div>
    </div>

    <div class="admin-main">
        <div class="admin-stats">
            <div class="stat-box">
                <div class="stat-icon purple">
                    🛡️
                </div>
                <div>
                    <div class="stat-label"><?php echo $myTeam ? htmlspecialchars($myTeam['name']) : 'No Team'; ?></div>
                    <div class="stat-value" style="font-size: 16px;">
                        <?php 
                        if ($myTeam) {
                            echo "W:" . $myTeam['stats_w'] . " D:" . $myTeam['stats_d'] . " L:" . $myTeam['stats_l'];
                        } else {
                            echo "N/A";
                        }
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="stat-box">
                <div class="stat-icon blue">
                    🏆
                </div>
                <div>
                    <div class="stat-label">Wins</div>
                    <div class="stat-value"><?php echo $myTeam ? $myTeam['stats_w'] : 0; ?></div>
                </div>
            </div>
            
            <div class="stat-box">
                <div class="stat-icon green">
                    ⭐
                </div>
                <div>
                    <div class="stat-label">Achievements</div>
                    <div class="stat-value" style="font-size: 14px;"><?php echo $myTeam && $myTeam['achievements'] ? htmlspecialchars($myTeam['achievements']) : 'None'; ?></div>
                </div>
            </div>
        </div>

        <div class="card wide">
            <h2>Upcoming Events</h2>
            <?php if (empty($upcomingTournaments)): ?>
                <div style="border: 1px solid #e6e9f2; border-radius: 8px; padding: 40px; text-align: center; color: var(--muted);">
                    There is no upcoming event currently
                </div>
            <?php else: ?>
                <ul style="list-style: none; padding: 0;">
                    <?php foreach ($upcomingTournaments as $evt): ?>
                        <li style="padding: 10px; border-bottom: 1px solid #eee;">
                            <strong><?php echo htmlspecialchars($evt['title']); ?></strong> - 
                            <?php echo date('M j, Y', strtotime($evt['start_date'])); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
