<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sea Of Black :: Shop</title>
        <link rel="icon" type="image/x-icon" href="./images/sea of black brewery logo black white.png">

        <link href="./cssbootstrap/bootstrap.css" rel="stylesheet">
        <link href="./css/metalhead.css" rel="stylesheet">
        <link href="./css/shopstyle.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Caveat&family=Nova+Square&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Miriam+Libre&display=swap" rel="stylesheet">

    </head>
    
    <body>
<?php 
    require 'inc\config.php';
    require 'inc\databaselogin.php';
    $beers = $db->getBeers();
    require 'inc\header.php'; 
?>


        <div class="top-shop-pic container-fluid">
            <div class="top-text">
                <h2 class="h2-edit">Welcome</h2>
                <h1 class="h1-edit">TO OUR SHOP</h1>
            </div>
        </div>

       <hr class="border-2" style="color: rgb(77, 61, 50); margin:0px;">

        <div class="container0">
            <?php if (empty($beers)): ?>
                <div class="alert alert-info">No products available. Add beers from the admin dashboard.</div>
            <?php else: ?>
                <div class="box-container0">
                    <?php foreach ($beers as $beer): ?>
                        <div class="box0">
                            <div class="image0">
                                <img src="<?php echo htmlspecialchars($beer['image'] ?: './images/shop/default.png'); ?>" alt="<?php echo htmlspecialchars($beer['name']); ?>" />
                                <div class="icons">
                                    <a href="#" class="cart-btn">Add to Cart</a>
                                </div>
                            </div>
                            <div class="content">
                                <h5><?php echo htmlspecialchars($beer['name']); ?></h5>
                                <div class="price">
                                    <?php echo number_format($beer['price'], 2); ?> EUR
                                </div>
                                <p><?php echo htmlspecialchars($beer['description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

       <hr class="border-2" style="color: rgb(77, 61, 50); margin:0px;">

<?php require 'inc\footer.php'; ?>
<?php require 'inc\script_menu.php'; ?>
<script src="./js/logout.js"></script>
    </body>
</html>