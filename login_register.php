<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Register</title>
    <link rel="stylesheet" href="login_register.css">
</head>
<body>
    <?php
    session_start();
    if (isset($_SESSION['error'])) {
        echo '<div class="popup" id="popup">' . htmlspecialchars($_SESSION['error']) . '</div>';
        unset($_SESSION['error']);      
    }
    if (isset($_SESSION['success'])) {
        echo '<div class="popup" id="popup">' . htmlspecialchars($_SESSION['success']) . '</div>';
        unset($_SESSION['success']);
    }
    ?>
    <div class="container">
        <div class="form-container">
            <h2>Sign into your account</h2>
            <h3>Login</h3>
            <form action="login.php" method="post">
                <label for="login-email">Email</label>
                <input type="email" id="login-email" name="email" required>
                <label for="login-password">Password</label>
                <input type="password" id="login-password" name="password" required>
                <button type="submit" class="btn">Confirm</button>
            </form>
            <h3>Register</h3>
            <form action="signup.php" method="post">
                <label for="register-username">Username</label>
                <input type="text" id="register-username" name="username" required>
                <label for="register-email">Email</label>
                <input type="email" id="register-email" name="email" required>
                <label for="register-password">Password</label>
                <input type="password" id="register-password" name="password" required>
                <button type="submit" class="btn">Confirm</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const popup = document.getElementById('popup');
            if (popup) {
                setTimeout(() => {
                    popup.style.display = 'none';
                }, 3000);
            }
        });
    </script>
</body>
</html>
