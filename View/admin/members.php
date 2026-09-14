<?php
session_start();
require_once __DIR__ . '/../../Controllers/auth_guard.php';
require_once __DIR__ . '/../../Controllers/database.php';
require_once __DIR__ . '/../../Model/User.php';

requireRole('admin');

$database = new Database();
$db = $database->connect();
$user = new User($db);

$pendingUsers = $user->getPendingUsers();
$approvedUsers = $user->getAllApprovedUsers();

$activeNav = 'members';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Members - Admin - ClubSphere</title>
    <link rel="stylesheet" href="../../Assets/css/style.css">
</head>
<body>
<div class="page">
    <div class="admin-layout">
        <?php include __DIR__ . '../../partials/sidebar.php'; ?>

        <div class="admin-main">

    <?php if (isset($_GET["success"])): ?>
        <p class="msg success">Action completed successfully.</p>
    <?php endif; ?>

    <div class="card wide">
        <h2>Pending Requests (<?php echo count($pendingUsers); ?>)</h2>
        <?php if (empty($pendingUsers)): ?>
            <p>No pending membership requests.</p>
        <?php else: ?>
            <table>
                <tr><th>Username</th><th>Email</th><th>Requested On</th><th>Assign Role</th><th></th></tr>
                <?php foreach ($pendingUsers as $p): ?>
                <tr>
                    <td><?php echo htmlspecialchars($p["username"]); ?></td>
                    <td><?php echo htmlspecialchars($p["email"]); ?></td>
                    <td><?php echo htmlspecialchars($p["joined_date"]); ?></td>
                    <td>
                        <form action="../../Controllers/AdminController.php" method="POST" class="inline-form">
                            <input type="hidden" name="action" value="approve_user">
                            <input type="hidden" name="user_id" value="<?php echo $p['id']; ?>">
                            <select name="role">
                                <option value="member">Member</option>
                                <option value="captain">Team Captain</option>
                                <option value="moderator">Moderator</option>
                                <option value="admin">Admin</option>
                            </select>
                            <button type="submit">Approve</button>
                        </form>
                    </td>
                    <td>
                        <form action="../../Controllers/AdminController.php" method="POST" class="inline-form">
                            <input type="hidden" name="action" value="reject_user">
                            <input type="hidden" name="user_id" value="<?php echo $p['id']; ?>">
                            <button type="submit" class="danger">Reject</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>

    <div class="card wide">
        <h2>All Members (<?php echo count($approvedUsers); ?>)</h2>
        <table>
            <tr><th>Username</th><th>Email</th><th>Current Role</th><th>Change Role</th></tr>
            <?php foreach ($approvedUsers as $a): ?>
            <tr>
                <td><?php echo htmlspecialchars($a["username"]); ?></td>
                <td><?php echo htmlspecialchars($a["email"]); ?></td>
                <td><?php echo htmlspecialchars(ucfirst($a["role"])); ?></td>
                <td>
                    <form action="../../Controllers/AdminController.php" method="POST" class="inline-form">
                        <input type="hidden" name="action" value="update_role">
                        <input type="hidden" name="user_id" value="<?php echo $a['id']; ?>">
                        <select name="role">
                            <option value="member" <?php echo $a["role"] == "member" ? "selected" : ""; ?>>Member</option>
                            <option value="captain" <?php echo $a["role"] == "captain" ? "selected" : ""; ?>>Team Captain</option>
                            <option value="moderator" <?php echo $a["role"] == "moderator" ? "selected" : ""; ?>>Moderator</option>
                            <option value="admin" <?php echo $a["role"] == "admin" ? "selected" : ""; ?>>Admin</option>
                        </select>
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

        </div>
    </div>
</div>
</body>
</html>
