<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sea Of Black Shop</title>
        <link rel="icon" type="image/x-icon" href="./images/sea of black brewery logo black white.png">

        <link href="./cssbootstrap/bootstrap.css" rel="stylesheet">
        <link href="./css/metalhead.css" rel="stylesheet">
        <link href="./css/loginstyle.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.js">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Arya&family=Caveat&family=Miriam+Libre&family=Nova+Square&display=swap" rel="stylesheet">

    </head>

    <body>
        <?php 
            require 'inc\header.php'; 
        ?>

        <div class="top-login-pic container-fluid">
            <div class="top-text">
                <h2 class="h2-edit">Log in </h2>
                <h1 class="h1-edit">TO GET MORE</h1>
            </div>
        </div>

        <h5>If you don't have an account, make sure to <a href="register.php">register</a> here</h5>

        <div class="divider"></div>

        <form name="login" method="POST" action="inc/handle_auth.php" id="loginForm" class="validate-form" novalidate="">
            <input type="hidden" name="action" value="login">
            <?php require_once 'inc/auth_helper.php'; echo csrfField(); ?>
            
            <div class="container0">
                <div class="email-phone">
                    <input type="email" id="email" name="email" placeholder="Email" required="true">
                    <span id="emailError" class="error-message"></span>
                </div>
                <div class="password">
                    <input type="password" id="password" name="password" placeholder="Password" required="true">
                    <span id="passwordError" class="error-message"></span>
                </div>
                <div id="messageBox" class="message-box"></div>
                <div class="sumbit">
                    <input type="submit" id="submit" value="Login">
                </div>
                <div class="psw"><a href="restorepass.php">Forgot your password?</a></div>
            </div>
        </form>
       
        <?php require 'inc\footer.php'; ?>
        <?php require 'inc\script_menu.php'; ?>
        <script src="js/login_data.js"></script>
    </body>

</html>