<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sea  Of Black :: Reviews</title>
        <link rel="icon" type="image/x-icon" href="./images/sea of black brewery logo black white.png">

        <link href="./cssbootstrap/bootstrap.css" rel="stylesheet">
        <link href="./css/metalhead.css" rel="stylesheet">
        <link href="./css/review.css" rel="stylesheet">
        <link href="./cssbootstrap/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Caveat&family=Nova+Square&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Miriam+Libre&display=swap" rel="stylesheet">

    </head>
    <body class="body-review">
<?php 
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");
    require 'inc\header.php'; 
    require 'inc/databaselogin.php';
    $reviews = $db->getApprovedReviews();
    echo '<script>window.IS_LOGGED_IN = ' . (isUserLoggedIn() ? 'true' : 'false') . ';</script>';
    if (isUserLoggedIn()) {
        echo '<script>window.REVIEW_USER_NAME = "' . htmlspecialchars(getCurrentUserName(), ENT_QUOTES, 'UTF-8') . '";</script>';
    }
    echo '<script>const reviews = ' . json_encode($reviews) . ';</script>';
?>

        <div class="top-pic-contact container-fluid">
            <div class="top-text">
                <h2 class="h2-edit">Share us</h2>
                <h1 class="h1-edit">YOUR EXPERIENCE</h1>
            </div>
        </div>

        <div style="background-color: rgb(77, 61, 50); height: 2px; margin-bottom: 36px;"></div>
        
        <div style="max-width: 85%; margin: 0 auto; position: relative;">
            <button id="prevReview" style="position: absolute; left: -60px; top: 50%; transform: translateY(-50%); background: none; border: none; font-size: 24px; color: #B77724; cursor: pointer;">&#10094;</button>
            <div class="box-review" id="reviewBox">
                <div class="avatar-and-name">
                    <img class="avatar" id="reviewAvatar" src="./images/review/default_profile.png">
                    <h3 class="name" id="reviewName">No Reviews Yet</h3>
                </div>
                <div class="star-rating" id="reviewStars">
                    <i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>
                </div>
                <div class="review-text" id="reviewText">
                    <q>Be the first to leave a review!</q>
                </div>
            </div>
            <button id="nextReview" style="position: absolute; right: -60px; top: 50%; transform: translateY(-50%); background: none; border: none; font-size: 24px; color: #B77724; cursor: pointer;">&#10095;</button>
        </div>

        <div class="h2-div"></div>
            <h2 class="h2-edit">Leave a Review</h2>
        </div>

        <div class="buttons">

                <button class="btn btn-danger" onclick="openAccountForm()">With account</button>
                <button class="btn btn-secondary" onclick="openGuestForm()">Anonymous</button>

        </div>

        <div style="background-color: rgb(77, 61, 50); height: 2px;margin-top: 36px;"></div>
        
<?php require 'inc\footer.php'; ?>

<!-- Guest Review Form (no picture upload, uses default profile) -->
<div class="overlay" id="guestOverlay"></div>   
<div class="form-popup" id="guestForm">
    <form id="guestReviewForm" action="inc/submit_review.php" method="POST" class="form-container">
        <?php require_once 'inc/auth_helper.php'; echo csrfField(); ?>
        <h2 class="h2-edit">Make sure to leave your review. Any criticism is welcome!</h2>
        
        <label for="guestReviewName"><b>Your Name</b></label>
        <input type="text" placeholder="Enter Name" name="name" id="guestReviewName" required>

        <label for="guestReviewComment"><b>Review</b></label>
        <textarea placeholder="Type in your review" name="comment" id="guestReviewComment" class="review-box" required></textarea>
        <input type="hidden" name="rating" id="guestReviewRating" value="0">
        <input type="hidden" name="account_review" value="0">
        <p id="guestReviewMessage" class="review-message"></p>

        <div class="star-rating">
            <span class="fa fa-star-o" onclick="rateGuestStar(this)"></span>
            <span class="fa fa-star-o" onclick="rateGuestStar(this)"></span>
            <span class="fa fa-star-o" onclick="rateGuestStar(this)"></span>
            <span class="fa fa-star-o" onclick="rateGuestStar(this)"></span>
            <span class="fa fa-star-o" onclick="rateGuestStar(this)"></span>
        </div>

        <div class="buttons">
            <button type="button" class="btn cancel" onclick="closeGuestForm()">Close</button>
            <button type="submit" class="btn">Submit</button>
        </div>

    </form>
</div>

<!-- Login required prompt -->
<div class="overlay" id="loginPromptOverlay"></div>
<div class="form-popup" id="loginPrompt">
    <div class="form-container">
        <h2 class="h2-edit">Please log in</h2>
        <p>You must be logged in to leave a review with an account.</p>
        <div class="buttons" style="justify-content: space-between; gap: 10px;">
            <button type="button" class="btn cancel" onclick="closeLoginPrompt()">Cancel</button>
            <button type="button" class="btn btn-danger" onclick="window.location.href='login.php'">Log in</button>
        </div>
    </div>
</div>

<!-- Account Review Form (with picture upload) -->
<div class="overlay" id="accountOverlay"></div>   
<div class="form-popup" id="accountForm">
    <form id="accountReviewForm" action="inc/submit_review.php" method="POST" enctype="multipart/form-data" class="form-container">
        <?php require_once 'inc/auth_helper.php'; echo csrfField(); ?>
        <h2 class="h2-edit">Make sure to leave your review. Any criticism is welcome!</h2>
        
        <label for="accountReviewName"><b>Your Name</b></label>
        <p id="accountReviewDisplayName" style="margin: 0; padding: 0.5rem 0;"></p>

        <label for="authorImage"><b>Profile Picture (Optional)</b></label>
        <input type="file" id="authorImage" name="author_image" accept="image/*">
        <small>Supported formats: JPG, JPEG, PNG, GIF</small>

        <label for="accountReviewComment"><b>Review</b></label>
        <textarea placeholder="Type in your review" name="comment" id="accountReviewComment" class="review-box" required></textarea>
        <input type="hidden" name="rating" id="accountReviewRating" value="0">
        <input type="hidden" name="account_review" value="1">
        <p id="accountReviewMessage" class="review-message"></p>

        <div class="star-rating">
            <span class="fa fa-star-o" onclick="rateAccountStar(this)"></span>
            <span class="fa fa-star-o" onclick="rateAccountStar(this)"></span>
            <span class="fa fa-star-o" onclick="rateAccountStar(this)"></span>
            <span class="fa fa-star-o" onclick="rateAccountStar(this)"></span>
            <span class="fa fa-star-o" onclick="rateAccountStar(this)"></span>
        </div>

        <div class="buttons">
            <button type="button" class="btn cancel" onclick="closeAccountForm()">Close</button>
            <button type="submit" class="btn">Submit</button>
        </div>

    </form>
</div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="./js/bootstrap.bundle.min.js"></script>
        <script src="./js/review_form.js"></script>
        <?php require 'inc\script_menu.php'; ?>
        <script src="./js/logout.js"></script>
        <script>
            let currentIndex = 0;
            const reviewBox = document.getElementById('reviewBox');
            const reviewAvatar = document.getElementById('reviewAvatar');
            const reviewName = document.getElementById('reviewName');
            const reviewStars = document.getElementById('reviewStars');
            const reviewText = document.getElementById('reviewText');
            const prevButton = document.getElementById('prevReview');
            const nextButton = document.getElementById('nextReview');

            function showReview(index) {
                if (reviews.length === 0) return;
                const review = reviews[index];
                reviewAvatar.src = review.author_image;
                reviewName.textContent = review.name || 'Guest';
                reviewStars.innerHTML = '';
                for (let i = 1; i <= 5; i++) {
                    const star = document.createElement('i');
                    star.className = 'fa ' + (i <= review.rating ? 'fa-star' : 'fa-star-o');
                    reviewStars.appendChild(star);
                }
                reviewText.innerHTML = '<q>' + review.comment + '</q>';
            }

            if (reviews.length > 0) {
                currentIndex = Math.floor(Math.random() * reviews.length);
                showReview(currentIndex);
                prevButton.style.display = 'block';
                nextButton.style.display = 'block';
            } else {
                prevButton.style.display = 'none';
                nextButton.style.display = 'none';
            }

            prevButton.addEventListener('click', () => {
                if (reviews.length === 0) return;
                currentIndex = (currentIndex - 1 + reviews.length) % reviews.length;
                showReview(currentIndex);
            });

            nextButton.addEventListener('click', () => {
                if (reviews.length === 0) return;
                currentIndex = (currentIndex + 1) % reviews.length;
                showReview(currentIndex);
            });
        </script>
    </body>

</html>