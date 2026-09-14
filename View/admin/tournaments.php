<?php
session_start();
require_once __DIR__ . '/../../Controllers/auth_guard.php';
require_once __DIR__ . '/../../Controllers/database.php';
require_once __DIR__ . '/../../Model/Tournament.php';

requireRole('admin');

$database = new Database();
$db = $database->connect();
$tournament = new Tournament($db);

$tournaments = $tournament->getAllTournaments();

$activeNav = 'tournaments';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tournaments - Admin - ClubSphere</title>
    <link rel="stylesheet" href="../../Assets/css/style.css">
</head>
<body>
<div class="page">
    <div class="admin-layout">
        <?php include __DIR__ . '../../partials/sidebar.php'; ?>

        <div class="admin-main">

    <?php if (isset($_GET["success"])): ?>
        <p class="msg success">Tournament saved successfully.</p>
    <?php endif; ?>

    <div class="card">
        <h2>Create New Tournament</h2>
        <form action="../../Controllers/AdminController.php" method="POST">
            <input type="hidden" name="action" value="create_tournament">

            <label>Title</label>
            <input type="text" name="title" required>

            <label>Game Type</label>
            <input type="text" name="game_type" placeholder="e.g. Valorant, MLBB" required>

            <label>Start Date</label>
            <input type="date" name="start_date" required>

            <label>End Date</label>
            <input type="date" name="end_date" required>

            <label>Prize Pool</label>
            <input type="number" step="0.01" name="prize_pool" required>

            <label>Region</label>
            <input type="text" name="region" required>

            <button type="submit">Create Tournament</button>
        </form>
    </div>

    <div class="card wide">
        <h2>All Tournaments</h2>
        <?php if (empty($tournaments)): ?>
            <p>No tournaments created yet.</p>
        <?php else: ?>
            <table>
                <tr><th>Title</th><th>Game</th><th>Dates</th><th>Prize</th><th>Region</th><th>Status</th></tr>
                <?php foreach ($tournaments as $t): ?>
                <tr>
                    <td><?php echo htmlspecialchars($t["title"]); ?></td>
                    <td><?php echo htmlspecialchars($t["game_type"]); ?></td>
                    <td><?php echo htmlspecialchars($t["start_date"]) . " - " . htmlspecialchars($t["end_date"]); ?></td>
                    <td><?php echo number_format($t["prize_pool"], 2); ?></td>
                    <td><?php echo htmlspecialchars($t["region"]); ?></td>
                    <td>
                        <span class="badge <?php echo $t['status']; ?>"><?php echo ucfirst($t["status"]); ?></span>
                        <form action="../../Controllers/AdminController.php" method="POST" class="inline-form" style="margin-top:6px;">
                            <input type="hidden" name="action" value="update_tournament_status">
                            <input type="hidden" name="tournament_id" value="<?php echo $t['id']; ?>">
                            <select name="status">
                                <option value="upcoming" <?php echo $t["status"] == "upcoming" ? "selected" : ""; ?>>Upcoming</option>
                                <option value="ongoing" <?php echo $t["status"] == "ongoing" ? "selected" : ""; ?>>Ongoing</option>
                                <option value="completed" <?php echo $t["status"] == "completed" ? "selected" : ""; ?>>Completed</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>

        </div>
    </div>
</div>
</body>
</html>
