<?php require_once 'auth_helper.php'; ?>

    <nav class="header fixed-top">
        <div class="left-section">
            <a style="text-decoration: none;" href="index.php">
                <img class="logo" src="./images/sea of black brewery logo.png">
            </a>
        </div> 
        <div class="right-section">
            <div class="menu-toggle" id="menu-toggle">
            <i class="fa fa-bars"></i>
            </div>
            <div class="elem">
                <ul id="nav-menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="story.php">Story</a></li>
                    <li><a href="beers.php">Our beers</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="contact.php">Contacts</a></li>
                    <li><a href="reviews.php">Reviews</a></li>
                    <?php if (isUserLoggedIn()): ?>
                    <li><a href="account.php">My Account</a></li>
                    <li><a href="#" onclick="logout()">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>