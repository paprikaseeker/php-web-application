<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sea Of Black :: Home Page</title>

    <link rel="icon" type="image/x-icon" href="./images/sea of black brewery logo black white.png">

    <link href="./cssbootstrap/bootstrap.css" rel="stylesheet">
    <link href="./css/metalhead.css" rel="stylesheet">
    <link href="./css/indexstyle.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arya&family=Caveat&family=Miriam+Libre&family=Nova+Square&display=swap" rel="stylesheet">
</head>
<body>

<?php 
    require 'inc\header.php'; 
?>

        <div class="top-pic container-fluid">
            <div class="top-text">
                <h2 class="h2-edit">Let the waves</h2>
                <h1 class="h1-edit">TINGLE YOUR SENSES</h1>
            </div>
        </div>

       <hr class="border-2" style="color: rgb(77, 61, 50); margin:0px;">

        <div class="container0 container-fluid px-0">
                <div class="main-name">
                    <div class="main-name-color">
                        <h5>A strong friendship</h5>
                    <p>And from the depth of Bulgaria&apos;s seaside there came The four &minus; sea, sun, music and beer. 
                    One warmed the body, one refreshed, one warmed the soul, and the other one energized. 
                    Which one is which? That&apos;s the thing &minus; they&apos;re all wrapped up into one &minus; The Sea of Black beer.</p>
                    </div>
                    <a href="story.php" class="btn btn-danger button-seaofblack">Read more</a>
                </div>
                <div class="table-main">
                <table class="table0" background="./images/home/0.png">
                    <tr>
                        <td><p>Sea</p></td>
                        <td><p>Sun</p></td>
                    </tr>
                    <tr>
                        <td><p>Music</p></td>
                        <td><p>Beer</p></td>
                    </tr>

                </table>
                </div>
            </div>

            <div class="youtube-video">
                <iframe width="960" height="540" frameborder ="0"  src="https://www.youtube.com/embed/P6ImFrY1SeE"></iframe>
        </div>

            <div class="container1 container-fluid px-0" style="background-image: url(./images/home/1.png); width:100%;">
                <div class="left0">
                    <h5>Some of our beers</h5>
                    <p>There&apos;s a lot to choose from &minus; we&apos;ll try not to overwhelm you.</p>
                    <a href="beers.php"class="btn btn-danger button-seaofblack">Read more</a>
                </div>
                <div class="right0">
                    <div class="pics">
                        <img src="./images/shop/yourgfsgf.png" style="width: 150px;">
                        <img src="./images/shop/lickitup.png" style="width: 150px;">
                        <img src="./images/shop/spacelord.png" style="width: 150px;">
                    </div>
                    <div class="right-text">
                        <p>Here are some of our pearls</p>
                        
                    </div>
                </div>
            </div>

            <hr class="border-2" style="color: rgb(77, 61, 50); margin:0px;">

<?php require 'inc\footer.php'; ?>
<?php require 'inc\script_menu.php'; ?>
<script src="./js/logout.js"></script>
    </body>

</html>