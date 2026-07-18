<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sea  Of Black :: Contacts</title>
        <link rel="icon" type="image/x-icon" href="./images/sea of black brewery logo black white.png">

        <link href="./cssbootstrap/bootstrap.css" rel="stylesheet">
        <link href="./css/metalhead.css" rel="stylesheet">
        <link href="./css/contacts.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Caveat&family=Nova+Square&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Miriam+Libre&display=swap" rel="stylesheet">

    </head>
    <body>
<?php 
    require 'inc\header.php'; 
?>

        <div class="top-pic-contact container-fluid">
            <div class="top-text">
                <h2 class="h2-edit">Make sure to</h2>
                <h1 class="h1-edit">CHECK US OUT</h1>
            </div>
        </div>

        <div style="background-color: rgb(77, 61, 50); height: 2px; margin-bottom: 38px;"></div>
    <div class="container-contact">
        <div class="container-text">
            <h3>Find us</h3>
            <div style="background-color: rgb(77, 61, 50); height: 2px"></div>
            <div class="containter-text-p">
            <p>Location: Mineralni Bani Park, 8124 Vetren district, Burgas, Bulgaria</p>
                <p>Email: info@seaofblack.beer</p>
            </div>
            <div class="containter-text-p">
                <p>Phone numbers:</p>
                <p>BG: +359 88 9836811 NL: +31624990911</p>
            </div>
        </div>
    </div>

    <div style="background-color: rgb(77, 61, 50);; height: 2px"></div>
    <div class="container-contact">
        <div class="container-text">
            <h3>Social media</h3>
        </div>
    </div>
    <div class="container-contact-us">
        <div class="social-media-box-facebook">
            <div style="background-color: rgb(77, 61, 50); height: 2px"></div>
            <button class="facebook-button">
            <a style="text-decoration: none;" href="#" target="_blank">
                <i class="fa fa-facebook-square"></i>
            <h3>Facebook</h3>
        </button>
        </a>
        </div>
        <div style="background-color: rgb(77, 61, 50); width: 2px;"></div>
        <div class="social-media-box-instagram">
            <div style="background-color: rgb(77, 61, 50); height: 2px"></div>
            <button class="instagram-button">
            <a style="text-decoration: none;" href="#" target="_blank"><i class="fa fa-instagram"></i>
            <h3>Instagram</h3>
        </button>
        </a>
        </div>
    </div>

    <div style="background-color: rgb(77, 61, 50); height: 2px;"></div>

    <div class="container-form">
        <?php
        // Display success message
        if (isset($_SESSION['contact_success'])) {
            echo '<div style="color: #B77724; text-align: center; margin-bottom: 20px; font-weight: bold;">' . $_SESSION['contact_success'] . '</div>';
            unset($_SESSION['contact_success']);
        }

        // Display error message
        if (isset($_SESSION['contact_error'])) {
            echo '<div style="color: #ff6b6b; text-align: center; margin-bottom: 20px; font-weight: bold;">' . $_SESSION['contact_error'] . '</div>';
            unset($_SESSION['contact_error']);
        }

        // Get preserved form data
        $formData = $_SESSION['contact_form_data'] ?? [];
        unset($_SESSION['contact_form_data']);
        ?>
        <form action="inc/contact_handler.php" method="POST">
            <?php require_once 'inc/auth_helper.php'; echo csrfField(); ?>
            <label for="fname">First name:</label><br>
            <input type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($formData['fname'] ?? ''); ?>" required><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>" required><br><br>
            <label for="message">Message:</label><br>
            <textarea placeholder="What's your message?" id="message" class="review-box" name="message" rows="4" cols="50" required><?php echo htmlspecialchars($formData['message'] ?? ''); ?></textarea><br><br>
            <button type="submit" class="btn">Submit</button>
        </form>
    </div>

    <div style="background-color: rgb(77, 61, 50); height: 2px;"></div>
<?php require 'inc\footer.php'; ?>
<?php require 'inc\script_menu.php'; ?>
<script src="./js/logout.js"></script>
    </body>

</html>