<?php include __DIR__ . '/partials/header.php'; ?>

<div class="card">
    <h2>Login</h2>

    <?php if (isset($_GET["success"])): ?>
        <p class="msg success">
            <?php
            if ($_GET["success"] == "registered") echo "Registration successful. Please login.";
            elseif ($_GET["success"] == "deleted") echo "Account deleted successfully.";
            ?>
        </p>
    <?php endif; ?>

    <?php if (isset($_GET["error"])): ?>
        <p class="msg error">
            <?php
            if ($_GET["error"] == "pending") echo "Your account is awaiting Admin approval.";
            elseif ($_GET["error"] == "rejected") echo "Your membership request was rejected.";
            else echo "Invalid username or password.";
            ?>
        </p>
    <?php endif; ?>

    <form action="../Controllers/AuthController.php" method="POST">
        <input type="hidden" name="action" value="login">

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
