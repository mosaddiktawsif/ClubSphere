<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../Controllers/database.php';
require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../Model/Tournament.php';

$database = new Database();
$db = $database->connect();
$user = new User($db);
$userData = $user->findById($_SESSION["user_id"]);

$tournamentObj = new Tournament($db);
$tournaments = $tournamentObj->getAllTournaments();

include __DIR__ . '/partials/header.php';
?>

<style>
.tourney-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-top: 20px;
}
.tourney-card {
    background: #1e284b; /* Darker blue to match PDF */
    color: #fff;
    padding: 24px;
    border-radius: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.tourney-info h3 {
    margin: 0 0 10px 0;
    font-size: 18px;
    font-weight: 600;
}
.tourney-meta {
    font-size: 14px;
    color: #a5b4fc;
    display: flex;
    gap: 15px;
}
.details-btn {
    background: rgba(255,255,255,0.1);
    color: #fff;
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    transition: background 0.2s;
}
.details-btn:hover {
    background: rgba(255,255,255,0.2);
    text-decoration: none;
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
        <div class="card wide" style="background: transparent; box-shadow: none;">
            <h2 style="font-size: 24px; font-weight: 500; margin-bottom: 20px;">Tournaments</h2>
            
            <div class="tourney-list">
                <?php if (empty($tournaments)): ?>
                    <p style="color: var(--muted);">No tournaments available.</p>
                <?php else: ?>
                    <?php foreach ($tournaments as $t): ?>
                        <div class="tourney-card">
                            <div class="tourney-info">
                                <h3><?php echo htmlspecialchars($t["title"]); ?></h3>
                                <div class="tourney-meta">
                                    <span>🎮 <?php echo htmlspecialchars($t["game_type"]); ?></span>
                                    <span>📅 <?php echo date('M j, Y', strtotime($t["start_date"])); ?></span>
                                    <span>
                                        <?php if ($t["status"] == 'upcoming'): ?>
                                            <span class="badge upcoming">Upcoming</span>
                                        <?php elseif ($t["status"] == 'ongoing'): ?>
                                            <span class="badge ongoing">Ongoing</span>
                                        <?php else: ?>
                                            <span class="badge completed">Completed</span>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                            <a href="tournament_details.php?id=<?php echo $t["id"]; ?>" class="details-btn">Details...</a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
