<!DOCTYPE html>
<html>
<head>
    <title>Login - ClubSphere</title>
</head>
<body style="font-family: Arial; background: #eef2f7; display: flex; justify-content: center; align-items: center; min-height: 100vh;">

<div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 400px; margin: 20px;">
    <h2>Captain Login</h2>
    
    <?php 
    $savedEmail = "";
    if (isset($_COOKIE['remember_email'])) {
        $savedEmail = $_COOKIE['remember_email'];
    }
    ?>
    
    <form action="index.php" method="POST">
        <input type="hidden" name="action" value="login">
        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($savedEmail); ?>" required style="width: 90%; padding: 10px; margin-bottom: 10px;"><br>
        <input type="password" name="password" placeholder="Password" required style="width: 90%; padding: 10px; margin-bottom: 10px;"><br>
        
        <label>
            <input type="checkbox" name="remember_me" <?php if ($savedEmail != "") echo "checked"; ?>> Remember Me
        </label><br><br>
        
        <button type="submit" style="width: 100%; padding: 10px; background: #2f81f7; color: white; border: none; border-radius: 5px;">Login</button>
    </form>

    <hr style="margin: 20px 0;">

    <h2>Register New Captain</h2>
    <form action="index.php" method="POST" id="registerForm">
        <input type="hidden" name="action" value="register">
        <input type="text" name="name" placeholder="Real Name" required style="width: 90%; padding: 10px; margin-bottom: 10px;"><br>
        <input type="text" name="ign" placeholder="In-Game Name" required style="width: 90%; padding: 10px; margin-bottom: 10px;"><br>
        <input type="text" name="phone" placeholder="Phone Number" required style="width: 90%; padding: 10px; margin-bottom: 10px;"><br>
        <input type="email" name="email" placeholder="Email Address" required style="width: 90%; padding: 10px; margin-bottom: 10px;"><br>
        <select name="game" required style="width: 96%; padding: 10px; margin-bottom: 10px;">
            <option value="">Select Primary Game</option>
            <option value="VALORANT">VALORANT</option>
            <option value="FC26">FC26</option>
            <option value="MLBB">MLBB</option>
            <option value="PUBG">PUBG</option>
            <option value="DOTA 2">DOTA 2</option>
        </select><br>
        <input type="password" name="password" id="regPassword" placeholder="Password" required style="width: 90%; padding: 10px; margin-bottom: 10px;"><br>
        
        <button type="submit" style="width: 100%; padding: 10px; background: #238636; color: white; border: none; border-radius: 5px;">Register Captain</button>
        <p id="errorText" style="color: red; font-size: 12px;"></p>
    </form>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', function(event) {
    var passwordInput = document.getElementById('regPassword').value;
    if (passwordInput.length < 6) {
        event.preventDefault();
        document.getElementById('errorText').innerText = "Password must be at least 6 characters.";
    }
});
</script>

</body>
</html>