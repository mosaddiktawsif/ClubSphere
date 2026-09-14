<?php 
$activeNav = 'dashboard';
require_once __DIR__ . '/partials/header.php'; 
?>

<div class="admin-layout">
    <?php require_once __DIR__ . '/partials/sidebar.php'; ?>

    <div class="admin-main">
        <div class="admin-stats">
            <div class="stat-box border-blue">
                <div class="stat-icon blue">&#128203;</div>
                <div>
                    <div class="stat-value">Roster</div>
                    <div class="stat-label">Manage your active team</div>
                </div>
            </div>
            <div class="stat-box border-red">
                <div class="stat-icon purple">&#128248;</div>
                <div>
                    <div class="stat-value">Score Proof</div>
                    <div class="stat-label">Pending match submissions</div>
                </div>
            </div>
        </div>

        <div class="card wide">
            <h2>Submit Match Score Evidence</h2>
            <p class="sidebar-subtitle">Self-report match outcomes and upload screenshot evidence for Moderator review.</p>
            
            <form action="index.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="submit_score">
                
                <label>Select Tournament</label>
                <select name="tournament_id" required>
                    <option value="">-- Choose Active Tournament --</option>
                    <?php foreach($tournaments as $tournament): ?>
                        <option value="<?php echo htmlspecialchars($tournament['id']); ?>"><?php echo htmlspecialchars($tournament['title']); ?></option>
                    <?php endforeach; ?>
                </select>
                
                <label>Match Score</label>
                <input type="text" name="score" placeholder="e.g., 13-10 or 2-0" required>
                
                <label>Upload Screenshot Proof</label>
                <input type="file" name="screenshot" accept="image/png, image/jpeg" required style="display: block; padding: 10px 0;">
                
                <button type="submit">Upload Proof</button>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>