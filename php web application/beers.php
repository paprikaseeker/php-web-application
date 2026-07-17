<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sea of Black :: Our Beers</title>
        <link rel="icon" type="image/x-icon" href="./images/sea of black brewery logo black white.png">

        <link href="./cssbootstrap/bootstrap.css" rel="stylesheet">
        <link href="./css/metalhead.css" rel="stylesheet">
        <link href="./css/beersstyle.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Arya&family=Caveat&family=Miriam+Libre&family=Nova+Square&display=swap" rel="stylesheet">

    </head>
    <body>
<?php 
    require 'inc\config.php';
    require 'inc\databaselogin.php';
    $beers = $db->getBeers();
    require 'inc\header.php'; 
?>

    <div class="top-beer-pic container-fluid">
            <div class="top-text">
                <h2 class="h2-edit">Perfect for some</h2>
                <h1 class="h1-edit">SUMMER FUN</h1>
            </div>
        </div>

        <div style="background-color: rgb(77, 61, 50); height: 2px;"></div>

        <div class="up-container container-fluid">
            <div class="column-1">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="64px" height="64px" viewBox="0 0 64 64" version="1.1" class="svg replaced-svg">
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Hops" stroke="#FFFFFF" stroke-width="2">
                            <g transform="translate(14.000000, 9.000000)">
                                <path d="M3,24 C1.833,27.667 2.708,31.792 5,34 C9.997,32.624 11.895,29.977 14,26" id="Stroke-1"></path>
                                <path d="M7,33 C6.375,37.458 9.031,39.937 11,42 C13.048,41.436 13.906,40.125 15,38" id="Stroke-3"></path>
                                <path d="M18,27.082 C20.542,26.583 25,23.833 25,20 C29.3,24.166 32.417,24.041 36,24.082 C36,13.125 27.941,6 18,6 C8.059,6 0,13.125 0,24.082 C3.583,24.041 6.7,24.166 11,20 C11,23.833 15.458,26.583 18,27.082 Z" id="Stroke-5"></path>
                                <path d="M33,24 C34.167,27.667 33.292,31.792 31,34 C26.003,32.624 24.105,29.977 22,26" id="Stroke-7"></path>
                                <path d="M25,31 C25,35.331 21.9,38.875 18,40 C14.1,38.875 11,35.331 11,31" id="Stroke-9"></path>
                                <path d="M29,33 C29.625,37.458 26.969,39.937 25,42 C22.952,41.436 22.094,40.125 21,38" id="Stroke-11"></path>
                                <path d="M23,40.9648 C22.063,44.1248 20.219,46.2188 18,46.9998 C15.781,46.2188 13.937,44.1248 13,40.9648" id="Stroke-13"></path>
                                <path d="M18,-7.10542736e-15 L18,6" id="Stroke-15"></path>
                            </g>
                        </g>
                    </g>
                </svg>
                <h3>WE STICK TO THE BASICS</h3>
                <p>We use only natural ingredients in our beers for the best tasting experience</p>
            </div>
            <div class="gap-color"></div>
            <div class="column-2">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="64px" height="64px" viewBox="0 0 64 64" version="1.1" class="svg replaced-svg">
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Sun" stroke="#FFFFFF" stroke-width="2">
                            <g id="Page-1" transform="translate(11.000000, 11.000000)">
                                <path d="M0.376,17.5742 L2.629,19.4972 C2.573,20.0742 2.54,20.6582 2.54,21.2502 C2.54,21.8422 2.573,22.4252 2.629,23.0032 L0.376,24.9262 C-0.281,25.4862 -0.037,26.5542 0.799,26.7752 L3.678,27.5342 C4.083,28.6362 4.59,29.6832 5.19,30.6732 L3.988,33.3982 C3.64,34.1892 4.322,35.0462 5.171,34.8822 L8.088,34.3182 C8.926,35.1302 9.839,35.8592 10.819,36.4992 L10.919,39.4662 C10.947,40.3292 11.936,40.8042 12.628,40.2892 L15.009,38.5172 C16.103,38.8812 17.241,39.1382 18.415,39.2882 L19.796,41.9252 C20.196,42.6902 21.292,42.6902 21.693,41.9252 L23.073,39.2882 C24.247,39.1382 25.387,38.8812 26.48,38.5172 L28.86,40.2892 C29.554,40.8042 30.541,40.3292 30.569,39.4662 L30.669,36.4992 C31.649,35.8592 32.564,35.1302 33.4,34.3182 L36.317,34.8822 C37.166,35.0462 37.85,34.1892 37.5,33.3982 L36.298,30.6732 C36.898,29.6832 37.405,28.6362 37.812,27.5342 L40.69,26.7752 C41.525,26.5542 41.77,25.4862 41.112,24.9262 L38.86,23.0032 C38.915,22.4252 38.948,21.8422 38.948,21.2502 C38.948,20.6582 38.915,20.0742 38.86,19.4972 L41.112,17.5742 C41.77,17.0122 41.525,15.9442 40.69,15.7232 L37.812,14.9652 C37.405,13.8642 36.898,12.8152 36.298,11.8262 L37.5,9.1002 C37.85,8.3092 37.166,7.4532 36.317,7.6172 L33.4,8.1802 C32.564,7.3702 31.649,6.6392 30.669,6.0002 L30.569,3.0332 C30.541,2.1702 29.554,1.6942 28.86,2.2102 L26.48,3.9812 C25.387,3.6182 24.247,3.3612 23.073,3.2112 L21.693,0.5742 C21.292,-0.1918 20.196,-0.1918 19.796,0.5742 L18.415,3.2112 C17.241,3.3612 16.103,3.6182 15.009,3.9812 L12.628,2.2102 C11.936,1.6942 10.947,2.1702 10.919,3.0332 L10.819,6.0002 C9.839,6.6392 8.926,7.3702 8.088,8.1802 L5.171,7.6172 C4.322,7.4532 3.64,8.3092 3.988,9.1002 L5.19,11.8262 C4.59,12.8152 4.083,13.8642 3.678,14.9652 L0.799,15.7232 C-0.037,15.9442 -0.281,17.0122 0.376,17.5742 Z" id="Stroke-1"></path>
                                <path d="M20.7441,7.499 C28.4761,7.499 34.7441,13.571 34.7441,21.062 C34.7441,23.618 34.0141,26.01 32.7451,28.051" id="Stroke-3"></path>
                                <path d="M28.0645,32.625 C25.9345,33.893 23.4275,34.624 20.7445,34.624 C13.0125,34.624 6.7445,28.552 6.7445,21.062" id="Stroke-5"></path>
                            </g>
                        </g>
                    </g>
                </svg>
                <h3>WE HARVEST THE LOCAL SUN</h3>
                <p>We produce our beers locked between the sun and sea of Burgas, Bulgaria</p>
            </div>
            <div class="gap-color"></div>
            <div class="column-3">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="64px" height="64px" viewBox="0 0 64 64" version="1.1" class="svg replaced-svg">
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="3DSixPack" stroke="#FFFFFF" stroke-width="2">
                            <g id="Page-1" transform="translate(9.000000, 13.000000)">
                                <path d="M21,19 L21,16.48 C21,13.75 17.994,12.551 17.994,11.127 C17.994,8.532 17,4.113 17,3.928 C17,3.459 18,2.742 18,1.855 L17.5,1 C17.5,0.447 17.127,0 16.667,0 L12.333,0 C11.873,0 11.5,0.447 11.5,1 L11,1.855 C11,2.742 12,3.459 12,3.928 C12,4.113 11.006,8.532 11.006,11.127 C11.006,11.746 10.438,12.322 9.796,13" id="Stroke-1"></path>
                                <path d="M32,19 L32,16.48 C32,13.75 28.994,12.551 28.994,11.127 C28.994,8.532 28,4.113 28,3.928 C28,3.459 29,2.742 29,1.855 L28.5,1 C28.5,0.447 28.127,0 27.667,0 L23.333,0 C22.873,0 22.5,0.447 22.5,1 L22,1.855 C22,2.742 23,3.459 23,3.928 C23,4.113 22.006,8.532 22.006,11.127 C22.006,11.746 21.438,12.322 20.797,13" id="Stroke-3"></path>
                                <path d="M43,19 L43,16.48 C43,13.75 39.994,12.551 39.994,11.127 C39.994,8.532 39,4.113 39,3.928 C39,3.459 40,2.742 40,1.855 L39.5,1 C39.5,0.447 39.127,0 38.667,0 L34.333,0 C33.873,0 33.5,0.447 33.5,1 L33,1.855 C33,2.742 34,3.459 34,3.928 C34,4.113 33.006,8.532 33.006,11.127 C33.006,11.746 32.438,12.322 31.797,13" id="Stroke-5"></path>
                                <path d="M18,3 L22,3" id="Stroke-11"></path>
                                <path d="M29,3 L33,3" id="Stroke-13"></path>
                                <path d="M12,19 L12,38" id="Stroke-15"></path>
                                <path d="M13,19 L45,19" id="Line" stroke-linecap="square"></path>
                                <path d="M6,3 L10,3" id="Line" stroke-linecap="square"></path>
                                <path d="M45,19 L45,38" id="Line" stroke-linecap="square"></path>
                                <path d="M1.00732422,19.6210327 L1.00732422,37.6210327" id="Line" stroke-linecap="square"></path>
                                <path d="M5.63891602,13.4294434 L1.41748047,18.4987183" id="Line" stroke-linecap="square"></path>
                                <path d="M11.9934692,13.4110107 L6.42156982,19" id="Line" stroke-linecap="square" transform="translate(9.207520, 16.205505) scale(-1, 1) translate(-9.207520, -16.205505) "></path>
                                <path d="M6,3 L6,13" id="Line" stroke-linecap="square"></path>
                                <path d="M1,38 L45,38" id="Line" stroke-linecap="square"></path>
                            </g>
                        </g>
                    </g>
                </svg>
                <h3>A WHOLE LOT OF TASTE</h3>
                <p>There&apos;s a different beer for everyone here</p>
            </div>
        </div>

        <div class="container0">
            <?php if (empty($beers)): ?>
                <div class="alert alert-info">No beers are available yet. Add them from the admin dashboard.</div>
            <?php else: ?>
                <div class="box-container0">
                    <?php foreach ($beers as $beer): ?>
                        <div class="box0">
                            <div class="image0">
                                <img src="<?php echo htmlspecialchars($beer['image'] ?: './images/shop/default.png'); ?>" alt="<?php echo htmlspecialchars($beer['name']); ?>" class="beer-pic">
                            </div>
                            <div class="content">
                                <h5><?php echo htmlspecialchars($beer['name']); ?></h5>
                                <p><?php echo nl2br(htmlspecialchars($beer['description'])); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div style="background-color: rgb(77, 61, 50); height: 2px;"></div>

<?php require 'inc\footer.php'; ?>
<?php require 'inc\script_menu.php'; ?>
<script src="./js/logout.js"></script>
    </body>
</html>
