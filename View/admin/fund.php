<?php
session_start();
require_once __DIR__ . '/../../Controllers/auth_guard.php';
require_once __DIR__ . '/../../Controllers/database.php';
require_once __DIR__ . '/../../Model/ClubFund.php';

requireRole('admin');

$database = new Database();
$db = $database->connect();
$fund = new ClubFund($db);

$transactions = $fund->getAllTransactions();
$balance = $fund->getBalance();

$activeNav = 'fund';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Club Fund - Admin </title>
    <link rel="stylesheet" href="../../Assets/css/style.css">
</head>
<body>
<div class="page">
    <div class="admin-layout">
        <?php include __DIR__ . '../../partials/sidebar.php'; ?>

        <div class="admin-main">

    <?php if (isset($_GET["success"])): ?>
        <p class="msg success">Transaction recorded successfully.</p>
    <?php endif; ?>

    <div class="card">
        <h2>Current Balance: <?php echo number_format($balance, 2); ?></h2>

        <form action="../../Controllers/AdminController.php" method="POST">
            <input type="hidden" name="action" value="add_transaction">

            <label>Type</label>
            <select name="type" required>
                <option value="income">Income (sponsorship, entry fee, etc.)</option>
                <option value="expense">Expense (logistics, equipment, etc.)</option>
            </select>

            <label>Description</label>
            <input type="text" name="description" required>

            <label>Amount</label>
            <input type="number" step="0.01" name="amount" required>

            <button type="submit">Add Transaction</button>
        </form>
    </div>

    <div class="card wide">
        <h2>Transaction History</h2>
        <?php if (empty($transactions)): ?>
            <p>No transactions recorded yet.</p>
        <?php else: ?>
            <table>
                <tr><th>Date</th><th>Type</th><th>Description</th><th>Amount</th><th>Logged By</th></tr>
                <?php foreach ($transactions as $t): ?>
                <tr>
                    <td><?php echo htmlspecialchars($t["transaction_date"]); ?></td>
                    <td class="<?php echo $t['type'] == 'income' ? 'text-green' : 'text-red'; ?>">
                        <?php echo ucfirst($t["type"]); ?>
                    </td>
                    <td><?php echo htmlspecialchars($t["description"]); ?></td>
                    <td><?php echo number_format($t["amount"], 2); ?></td>
                    <td><?php echo htmlspecialchars($t["logged_by"] ?? "—"); ?></td>
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
