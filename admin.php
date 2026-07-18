<?php
require_once 'inc/config.php';
require_once 'inc/auth_helper.php';
require_once 'inc/databaselogin.php';

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}

// Check if admin
if (!isUserAdmin()) {
    header("Location: index.php");
    exit;
}

$pendingReviews = $db->getPendingReviews();
$beers = $db->getBeers();
$allReviews = $db->getAllReviews();
$averageRating = $db->calculateRating();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sea Of Black :: Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="./images/sea of black brewery logo black white.png">

    <link href="./cssbootstrap/bootstrap.css" rel="stylesheet">
    <link href="./css/metalhead.css" rel="stylesheet">
    <link href="./css/indexstyle.css" rel="stylesheet">
    <link href="./css/adminstyle.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arya&family=Caveat&family=Miriam+Libre&family=Nova+Square&display=swap" rel="stylesheet">
</head>
<body style="background-color: #4d3d32;">
<?php require 'inc/header.php'; ?>

<div style="margin-top: 150px;">
    <h1>Admin Dashboard</h1>

    <div class="row">
        <div class="col-md-6">
            <h3>Pending Reviews</h3>
            <?php if (empty($pendingReviews)): ?>
                <p>No pending reviews.</p>
            <?php else: ?>
                <div class="list-group">
                    <?php foreach ($pendingReviews as $review): ?>
                        <div class="list-group-item">
                            <h5><?php echo htmlspecialchars($review['name']); ?></h5>
                            <p><?php echo htmlspecialchars($review['comment']); ?></p>
                            <small>Rating: <?php echo $review['rating']; ?>/5</small>
                            <button class="btn btn-danger btn-sm float-end delete-btn" data-id="<?php echo $review['id']; ?>">Delete</button>
                            <button class="btn btn-success btn-sm float-end me-2 approve-btn" data-id="<?php echo $review['id']; ?>">Approve</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <h3>Add New Beer</h3>
            <form id="addBeerForm" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="beerName" class="form-label">Beer Name</label>
                    <input type="text" class="form-control" id="beerName" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="beerDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="beerDescription" name="description" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="beerPrice" class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control" id="beerPrice" name="price" required>
                </div>
                <div class="mb-3">
                    <label for="beerStock" class="form-label">Stock</label>
                    <input type="number" class="form-control" id="beerStock" name="stock" required>
                </div>
                <div class="mb-3">
                    <label for="beerImage" class="form-label">Beer Image</label>
                    <input type="file" class="form-control" id="beerImage" name="beerImage" accept="image/png, image/jpeg, image/gif">
                </div>
                <button type="submit" class="btn btn-primary">Add Beer</button>
            </form>
            <div id="beerMessage" class="mt-3"></div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h3>Review Ratings</h3>
            <p><strong>Average approved rating:</strong> <?php echo number_format($averageRating, 2); ?> / 5</p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Comment</th>
                        <th>Rating</th>
                        <th>Approved</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($allReviews)): ?>
                        <tr>
                            <td colspan="4">No reviews available.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($allReviews as $review): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($review['name'] ?: 'Guest'); ?></td>
                                <td><?php echo htmlspecialchars($review['comment']); ?></td>
                                <td>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fa <?php echo $i <= $review['rating'] ? 'fa-star' : 'fa-star-o'; ?>" aria-hidden="true"></i>
                                    <?php endfor; ?>
                                    <span class="ms-2"><?php echo (int) $review['rating']; ?>/5</span>
                                </td>
                                <td><?php echo $review['approved'] ? 'Yes' : 'No'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h3>Current Beers</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($beers as $beer): ?>
                        <tr>
                            <td><img src="<?php echo htmlspecialchars($beer['image'] ?: './images/shop/default.png'); ?>" alt="<?php echo htmlspecialchars($beer['name']); ?>" style="max-width: 100px; height: auto;"></td>
                            <td><?php echo htmlspecialchars($beer['name']); ?></td>
                            <td><?php echo htmlspecialchars($beer['description']); ?></td>
                            <td>$<?php echo number_format($beer['price'], 2); ?></td>
                            <td><?php echo $beer['stock']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="./js/bootstrap.bundle.min.js"></script>
<?php require 'inc/script_menu.php'; ?>
<script src="./js/logout.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Approve review buttons
    document.querySelectorAll('.approve-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const reviewId = this.getAttribute('data-id');
            fetch('inc/admin_actions.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'action=approve_review&id=' + reviewId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.closest('.list-group-item').remove();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        });
    });

    // Delete review buttons
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this review?')) {
                const reviewId = this.getAttribute('data-id');
                fetch('inc/admin_actions.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=delete_review&id=' + reviewId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.closest('.list-group-item').remove();
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
            }
        });
    });

    // Add beer form
    document.getElementById('addBeerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('action', 'add_beer');

        fetch('inc/admin_actions.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const messageDiv = document.getElementById('beerMessage');
            messageDiv.textContent = data.message;
            messageDiv.className = data.success ? 'alert alert-success' : 'alert alert-danger';
            if (data.success) {
                this.reset();
                // Optionally reload the beers table
                setTimeout(() => location.reload(), 1000);
            }
        });
    });
});
</script>
</body>
</html>
