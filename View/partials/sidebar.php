<?php

$activeNav = $activeNav ?? '';
?>
<div class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-badge">CS</div>
        <div>
            <div class="sidebar-title">ClubSphere</div>
            <div class="sidebar-subtitle">Admin Panel</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <a href="panel.php" class="<?php echo $activeNav == 'dashboard' ? 'active' : ''; ?>">Dashboard</a>
        <a href="members.php" class="<?php echo $activeNav == 'members' ? 'active' : ''; ?>">Members List</a>
        <a href="fund.php" class="<?php echo $activeNav == 'fund' ? 'active' : ''; ?>">Fund</a>
        <a href="tournaments.php" class="<?php echo $activeNav == 'tournaments' ? 'active' : ''; ?>">Tournaments</a>
        <a href="../dashboard.php">My Dashboard</a>
        <a href="../../logout.php">Logout</a>
    </nav>
</div>
