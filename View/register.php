<?php include __DIR__ . '/partials/header.php'; ?>

<div class="card">
    <h2>Register</h2>

    <?php if (isset($_GET["error"])): ?>
        <p class="msg error">
            <?php
            if ($_GET["error"] == "password_mismatch") echo "Passwords do not match.";
            elseif ($_GET["error"] == "username_taken") echo "That username is already taken.";
            else echo "Registration failed. Please try again.";
            ?>
        </p>
    <?php endif; ?>

    <form action="../Controllers/AuthController.php" method="POST">
        <input type="hidden" name="action" value="register">

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>
