<?php
require_once 'inc/config.php';
require_once 'inc/auth_helper.php';
require_once 'inc/databaselogin.php';
requireLogin(); // Redirect to login if not authenticated

$userData = $db->getUserData(getCurrentUserId());
if (!$userData) {
    die("User not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sea Of Black :: My Account</title>
    <link rel="icon" type="image/x-icon" href="./images/sea of black brewery logo black white.png">

    <link href="./cssbootstrap/bootstrap.css" rel="stylesheet">
    <link href="./css/metalhead.css" rel="stylesheet">
    <link href="./css/accountstyle.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arya&family=Caveat&family=Miriam+Libre&family=Nova+Square&display=swap" rel="stylesheet">
</head>
<body class="body-account">
<?php require 'inc/header.php'; ?>

<div class="top-story-pic container-fluid">
            <div class="top-text">
                <h2 class="h2-edit">Your rules</h2>
                <h1 class="h1-edit">YOUR ACCOUNT</h1>
            </div>
        </div>

<div class="container mt-5">
    <h2>My Account</h2>
    <div class="row">
        <div class="col-md-6">
            <h4>Profile Information</h4>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($userData['firstname'] . ' ' . $userData['lastname']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($userData['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($userData['phonenumber'] ?? 'Not provided'); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars(($userData['address'] ?? '') . ', ' . ($userData['city'] ?? '') . ', ' . ($userData['country'] ?? '')); ?></p>
        </div>
        <div class="col-md-6">
            <h4>Account Actions</h4>
            <a href="#" class="btn btn-primary">Edit Profile</a>
            <a href="#" class="btn btn-secondary">Change Password</a>
        </div>
    </div>
</div>

<?php require 'inc/footer.php'; ?>
<?php require 'inc/script_menu.php'; ?>
<script src="./js/logout.js"></script>
</body>
</html>