<?php
session_start();
require_once __DIR__ . '/../../Controllers/auth_guard.php';
require_once __DIR__ . '/../../Controllers/database.php';
require_once __DIR__ . '/../../Model/User.php';
require_once __DIR__ . '/../../Model/ClubFund.php';

requireRole('admin');

$database = new Database();
$db = $database->connect();

$user = new User($db);
$fund = new ClubFund($db);

$totalMembers = $user->countApprovedMembers();
$pendingCount = count($user->getPendingUsers());
$balance = $fund->getBalance();

$activeNav = 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - ClubSphere</title>
    <link rel="stylesheet" href="../../Assets/css/style.css">
</head>
<body>
<div class="page">
    <div class="admin-layout">
        <?php include __DIR__ . '../../partials/sidebar.php'; ?>

        <div class="admin-main">
            <div class="admin-stats">
                <div class="stat-box">
                    <div class="stat-icon purple">&#128101;</div>
                    <div>
                        <div class="stat-value"><?php echo $totalMembers; ?></div>
                        <div class="stat-label">Total Members</div>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon blue">&#128203;</div>
                    <div>
                        <div class="stat-value"><?php echo $pendingCount; ?></div>
                        <div class="stat-label">Pending Requests</div>
                    </div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon green">&#2547;</div>
                    <div>
                        <div class="stat-value">&#2547;<?php echo number_format($balance, 2); ?></div>
                        <div class="stat-label">Club Fund Balance</div>
                    </div>
                </div>
            </div>

            <div class="card wide">
                <h2>Welcome, Admin</h2>
                <p>Use the sidebar to manage membership approvals, the club fund ledger, and tournaments.</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
