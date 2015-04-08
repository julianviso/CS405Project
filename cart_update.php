<!--
cart_update.php
Purpose:
    Updates the shopping cart.
Preconditions:
    The customer sends a post request from the Purchase.php page to alter the following information:

    $_SESSION["cart_items"] is an array containing the following:
        ["prod_id"]  -> the product ID (INTEGER)
        ["name"]        -> the product name (VARCHAR(30) in db)
        ["price"]       -> the product price (INTEGER)
        ["qty"]         -> the number of this item type in the cart

    See the if/else statements for the checks on what the GET requests should look like.

Postconditions:
    Values are set as requested and the cart is updated.
        
-->
<!DOCTYPE html>

<html>
    <head>
    <title> Updating cart... </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="css/menu.css" rel="stylesheet" type="text/css" media="all"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script src="js/script.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> 
    <script type="text/javascript" src="js/nav.js"></script>
    <script type="text/javascript" src="js/move-top.js"></script>
    <script type="text/javascript" src="js/easing.js"></script>
    <script type="text/javascript" src="js/nav-hover.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>

        <?php
            //session_start();
            require "sql/serverinfo.php";
            include "components/header_top.php";
            include "components/header_menu.html";

            if (!isset($_SESSION["email"])) {
                //header("location: PleaseLogin.php");
                //exit();
            }

        ?>
    </head>
    <body>
    <?php

        include "cart_functions.php";
        // ------------------------------------------------------
        // BEGIN CHECKING WHAT KIND OF GET REQUEST IT IS


        //empty cart 
        if(isset($_GET["emptycart"]) &&  $_GET["emptycart"]==1 && isset($_GET["return_url"]))
        {
            empty_cart();
            countProducts();
            $return_url = base64_decode($_GET["return_url"]);
            header('Location:'.$return_url);
        }

        //remove item from shopping cart
        else if(isset($_GET["removep"]) && isset($_GET["return_url"]) && isset($_SESSION["cart_items"]))
        {
            removep();
            countProducts();
            $return_url = base64_decode($_GET["return_url"]);
            header('Location:'.$return_url);
        }

        //change a quantity of a specified product
        else if(isset($_GET["setQtyp"]) && isset($_GET["return_url"]) && isset($_GET["newQty"]) && isset($_SESSION["cart_items"])){
            setQtyp();
            countProducts();
            $return_url = base64_decode($_GET["return_url"]);
            header('Location:'.$return_url);            
        }

        //add a product to the cart
        else if(isset($_GET["addProduct"]) && isset($_GET["return_url"])) {
            //addProduct will check this time if the cart_items is set
            addProduct();
            countProducts();
            $return_url = base64_decode($_GET["return_url"]);
            header('Location:'.$return_url);

        }

        //just update the number in the cart
        else if(isset($_GET["countProducts"]) && isset($_GET["return_url"])){
            countProducts();
            $return_url = base64_decode($_GET["return_url"]);
            //redirect back to original page
            header('Location:'.$return_url);
        }

        //None of these
        else if(isset($_GET["return_url"])){
            $return_url = base64_decode($_GET["return_url"]); //return url
            //redirect back to original page
            header('Location:'.$return_url);

        }

        //Something else went wrong even with the return url
        else {
            echo 'ERROR: missing GET parameters';
        }

        
        
        include "components/footer.html";
    ?>
    
    </body>
</html>