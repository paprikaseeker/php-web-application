<?php
require_once 'inc/auth_helper.php';
require_once 'inc/databaselogin.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Restore Password - Sea Of Black Shop</title>
        <link rel="icon" type="image/x-icon" href="./images/sea of black brewery logo black white.png">

        <link href="./cssbootstrap/bootstrap.css" rel="stylesheet">
        <link href="./css/metalhead.css" rel="stylesheet">
        <link href="./css/restorepass.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Arya&family=Caveat&family=Miriam+Libre&family=Nova+Square&display=swap" rel="stylesheet">

    </head>

    <body>
        <?php 
            require 'inc\header.php'; 
        ?>
        <div class="top-login-pic">
            <div class="top-text">
                <h2 class="h2-edit">Forgot Password?</h2>
                <h1 class="h1-edit">REGAIN ACCESS</h1>
            </div>
        </div>

        <h5>Enter your email to receive a password reset link</h5>

        <div class="divider"></div>

        <div class="container0">
            <?php
            // Check if this is a password reset with token
            $token = $_GET['token'] ?? '';
            
            if (!empty($token)): ?>
                <!-- Reset Password Form -->
                <form id="resetForm" method="POST" action="inc/handle_auth.php">
                    <input type="hidden" name="action" value="reset_password">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    <?php require_once 'inc/auth_helper.php'; echo csrfField(); ?>
                    
                    <div class="password">
                        <input type="password" id="newPassword" name="newPassword" placeholder="New Password" required="true">
                        <small>At least 8 characters, with uppercase, lowercase, and numbers</small>
                    </div>
                    <div class="password">
                        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required="true">
                    </div>
                    <div id="messageBox" class="message-box"></div>
                    <div class="sumbit">
                        <input type="submit" value="Reset Password">
                    </div>
                </form>
            <?php else: ?>
                <!-- Forgot Password Form -->
                <form id="forgotForm" method="POST" action="inc/handle_auth.php">
                    <input type="hidden" name="action" value="forgot_password">
                    <?php require_once 'inc/auth_helper.php'; echo csrfField(); ?>
                    
                    <div class="email-phone">
                        <input type="email" id="email" name="email" placeholder="Enter your email address" required="true">
                    </div>
                    <div id="messageBox" class="message-box"></div>
                    <div class="sumbit">
                        <input type="submit" value="Send Reset Link">
                    </div>
                </form>
            <?php endif; ?>
        </div>

        <?php require 'inc\footer.php'; ?>

        <script>
            document.getElementById("menu-toggle").onclick = function() {
                document.getElementById("nav-menu").classList.toggle("show");
            };

            // Handle forgot password form
            const forgotForm = document.getElementById('forgotForm');
            if (forgotForm) {
                forgotForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const messageBox = document.getElementById('messageBox');
                    
                    fetch('inc/handle_auth.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        messageBox.innerHTML = `<p class="${data.success ? 'success' : 'error'}">${data.message}</p>`;
                        
                        if (data.success) {
                            forgotForm.reset();
                        }
                    })
                    .catch(error => {
                        messageBox.innerHTML = '<p class="error">An error occurred. Please try again.</p>';
                        console.error('Error:', error);
                    });
                });
            }

            // Handle password reset form
            const resetForm = document.getElementById('resetForm');
            if (resetForm) {
                resetForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const newPassword = document.getElementById('newPassword').value;
                    const confirmPassword = document.getElementById('confirmPassword').value;
                    const messageBox = document.getElementById('messageBox');
                    
                    // Validate passwords match
                    if (newPassword !== confirmPassword) {
                        messageBox.innerHTML = '<p class="error">Passwords do not match</p>';
                        return;
                    }
                    
                    // Validate password strength
                    if (newPassword.length < 8) {
                        messageBox.innerHTML = '<p class="error">Password must be at least 8 characters long</p>';
                        return;
                    }
                    if (!/[A-Z]/.test(newPassword)) {
                        messageBox.innerHTML = '<p class="error">Password must contain at least one uppercase letter</p>';
                        return;
                    }
                    if (!/[a-z]/.test(newPassword)) {
                        messageBox.innerHTML = '<p class="error">Password must contain at least one lowercase letter</p>';
                        return;
                    }
                    if (!/[0-9]/.test(newPassword)) {
                        messageBox.innerHTML = '<p class="error">Password must contain at least one number</p>';
                        return;
                    }
                    
                    const formData = new FormData(this);
                    
                    fetch('inc/handle_auth.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        messageBox.innerHTML = `<p class="${data.success ? 'success' : 'error'}">${data.message}</p>`;
                        
                        if (data.success) {
                            setTimeout(() => {
                                window.location.href = 'login.php';
                            }, 2000);
                        }
                    })
                    .catch(error => {
                        messageBox.innerHTML = '<p class="error">An error occurred. Please try again.</p>';
                        console.error('Error:', error);
                    });
                });
            }
        </script>
    </body>

</html>
