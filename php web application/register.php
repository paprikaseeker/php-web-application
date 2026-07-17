<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Sea Of Black Shop</title>
        <link rel="icon" type="image/x-icon" href="./images/sea of black brewery logo black white.png">

        <link href="./cssbootstrap/bootstrap.css" rel="stylesheet">
        <link href="./css/metalhead.css" rel="stylesheet">
        <link href="./css/registerstyle.css" rel="stylesheet">        
        

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Arya&family=Caveat&family=Miriam+Libre&family=Nova+Square&display=swap" rel="stylesheet">

    </head>

    <body>
        <?php 
            require 'inc\header.php'; 
        ?>

        <div class="top-register-pic container-fluid">
            <div class="top-text">
                <h2 class="h2-edit">Interested for more</h2>
                <h1 class="h1-edit">REGISTER TO GET MORE</h1>
            </div>
        </div>

        <h5>Make sure to fill in everything</h5>

        
        <div class="container0">
           <form name="details" method="POST" action="inc/handle_auth.php" id="registerForm" class="validate-form" novalidate="">
                <input type="hidden" name="action" value="register">
                <?php require_once 'inc/auth_helper.php'; echo csrfField(); ?>
                
                <div class="first-last-name">
                    <input type="text" id="firstName" name="firstName" placeholder="First Name" required="true">
                    <input type="text" id="lastName" name="lastName" placeholder="Last Name" required="true">
                </div>
                <div class="password">
                    <input type="password" id="password" name="password" placeholder="Password" required="true">
                    <small>At least 8 characters, with uppercase, lowercase, and numbers</small>
                </div>
                <div class="email-phone">
                    <input type="email" id="email" name="email" placeholder="Email" required="true">
                    <input type="tel" id="phoneNumber" name="phoneNumber" placeholder="Phone Number" required="true">
                </div>
                <div class="country">
                    <select name="country" id="country" required="true">
                        <option value="">Select Country</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="Albania">Albania</option>
                        <option value="Austria">Austria</option>
                        <option value="Belarus">Belarus</option>
                        <option value="Belgium">Belgium</option>
                        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                        <option value="Bulgaria">Bulgaria</option>
                        <option value="Croatia">Croatia (Hrvatska)</option>
                        <option value="Czech Republic">Czech Republic</option>
                        <option value="France">France</option>
                        <option value="Germany">Germany</option>
                        <option value="Greece">Greece</option>
                        <option value="Hungary">Hungary</option>
                        <option value="Italy">Italy</option>
                        <option value="Luxembourg">Luxembourg</option>
                        <option value="Macedonia">Macedonia</option>
                        <option value="Malta">Malta</option>
                        <option value="Moldova">Moldova</option>
                        <option value="Monaco">Monaco</option>
                        <option value="Montenegro">Montenegro</option>
                        <option value="Netherlands">Netherlands</option>
                        <option value="Poland">Poland</option>
                        <option value="Portugal">Portugal</option>
                        <option value="Romania">Romania</option>
                        <option value="Serbia">Serbia</option>
                        <option value="Slovakia">Slovakia</option>
                        <option value="Slovenia">Slovenia</option>
                        <option value="Spain">Spain</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="Denmark">Denmark</option>
                        <option value="Estonia">Estonia</option>
                        <option value="Greenland">Greenland</option>
                        <option value="Latvia">Latvia</option>
                        <option value="Lithuania">Lithuania</option>
                        <option value="Norway">Norway</option>
                        <option value="Sweden">Sweden</option>
                        <option value="Switzerland">Switzerland</option>
                        <option value="Turkey">Turkey</option>
                    </select>
                </div>
                <div class="city-postal">
                    <input type="text" id="city" name="city" placeholder="City" required="true">
                    <input type="text" id="postal" name="postal" placeholder="Postal Code" required="true">
                </div>
                <div class="delivery-address">
                    <textarea id="address" name="address" placeholder="Delivery address" rows="4" required="true"></textarea>
                </div>
                <div id="messageBox" class="message-box"></div>
                <div class="sumbit">
                    <input type="submit" id="submit" value="Register">
                </div>
            </form>
        </div>

        <?php require 'inc\footer.php'; ?>
        <?php require 'inc\script_menu.php'; ?>
        <script src="js/register_password.js"></script>
    </body>

</html>