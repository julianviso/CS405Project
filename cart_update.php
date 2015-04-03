<!--
cart_update.php
Purpose:
    Updates the shopping cart.
Preconditions:
    The customer sends a post request from the Purchase.php page to alter the following information:

    $_SESSION["cart_items"] is an array containing the following:
        ["product_id"]  -> the product ID (INTEGER)
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
        /**
        * empty_cart
        * Purpose:
        *   Removes everything from the cart.
        * Preconditions:
        *   Assumes there is a return url to go back to.  Assumes the 
        *   session cart_items is initialized.
        * Postconditions:
        *   Throws away the cart and redirects to the return url.
        */
        function empty_cart(){
            $return_url = base64_decode($_GET["return_url"]); //return url
            echo $_SESSION["cart_items"];
            unset($_SESSION["cart_items"]);
            header('Location:'.$return_url);
        }

        /**
        * removep
        * Purpose:
        *   Removes all quantities of a given product from the cart.
        * Preconditions:
        *   $_SESSION["cart_items"] is initialized already.
        *   There is a return url to return to.
        * Postconditions:
        *   unsets the cart product id and returns to the return url.
        */
        function removep(){
            $product_id = $_GET["removep"]; //get the product product_id to remove
            $return_url = base64_decode($_GET["return_url"]); //get return url

            foreach ($_SESSION["cart_items"] as $key => $cart_item) {
                if($cart_item["product_id"]==$product_id){
                    $temp = $_SESSION["cart_items"];
                    unset($temp[$key]);
                    $_SESSION["cart_items"] = $temp;
                }
            }

            //redirect back to original page
            header('Location:'.$return_url);
        }

        /**
        * setQtyp
        * Purpose:
        *   Changes the quantity of a given product from the cart.
        * Preconditions:
        *   $_SESSION["cart_items"] is initialized already.
        *   $_GET["setQtyp"] exists, and supplies the product_id
        *   $_GET["newQty"] exists, and supplies the new quantity
        *   There is a return url to return to.
        * Postconditions:
        *   Decrements the quantity of an item by 1.
        *   If that sets the quantity to 0, removes it from the cart.
        */
        function setQtyp(){
            $product_id = $_GET["setQtyp"]; //get the product product_id to remove
            $newQty = $_GET["newQty"];
            $return_url = base64_decode($_GET["return_url"]); //get return url

            foreach ($_SESSION["cart_items"] as $key => $cart_item) {
                if($cart_item["product_id"]==$product_id){
                    //Getting the products from the cart
                    $tempCart = $_SESSION["cart_items"];
                    $tempProduct = $tempCart[$key];
                    $tempQty = $tempProduct["qty"];
                    
                    //Change the quantity if it will be greater than 0
                    if ($newQty > 0){
                        $tempQty = $newQty;
                        $tempProduct["qty"] = $tempQty;
                        $tempCart[$key] = $tempProduct;
                    }
                    //Otherwise, remove it from the cart
                    else {
                        unset($tempCart[$key]);
                    }
                    //Put back into the cart to save
                    $_SESSION["cart_items"] = $tempCart;
                }
            }

            //redirect back to original page
            header('Location:'.$return_url);
        }

        /**
        * addProduct
        * Purpose:
        *   Adds an item to the cart.
        * Preconditions:
        *   $_SESSION["cart_items"] is initialized already.
        *   $_GET["addProduct"] exists, and supplies the product_id
        *   $_GET["newName"] exists, and supplies the product name
        *   $_GET["newQty"] exists, and supplies the new quantity
        *   $_GET["newPrice"] exists, and supplies the product's price
        *   There is a return url to return to.
        * Postconditions:
        *   The new item is added to the user's cart for this session.
        *   
        */
        function addProduct(){
            //GET parameters
            $product_id = $_GET["addProduct"]; 
            $newName = $_GET["newName"];
            $newQty = $_GET["newQty"];
            $newPrice = $_GET["newPrice"];
            $return_url = base64_decode($_GET["return_url"]); //get return url
            //Now put them into the new array
            $tempProduct = array();
            $tempProduct["product_id"] = $product_id;
            $tempProduct["name"] = $newName;
            $tempProduct["price"] = $newPrice;
            $tempProduct["qty"] = $newQty;
            
            //Get the current session array and add the new product
            $tempCart = null;
            if(isset($_SESSION["cart_items"])){
                $tempCart = $_SESSION["cart_items"];
            }
            else{
                $tempCart = array();
            }
            $tempCart[$product_id] = $tempProduct;
            $_SESSION["cart_items"] = $tempCart;
        }

        /**
        * countProducts()
        * Purpose:
        *   Counts the total number of items in the cart.
        * Preconditions:
        *   $_SESSION["cart_items"] may or may not be initialized.
        *   $_GET["countProducts"] contains the return url
        * Postconditions:
        *   Returns the total number of items in the cart.
        *   Updates $_SESSION["Cart_qty"]
        */
        function countProducts(){
            $return_url = base64_decode($_GET["return_url"]); //get return url
            $total = 0;
            if(isset($_SESSION["cart_items"])){

                foreach ($_SESSION["cart_items"] as $cart_item) {
                    $total = $total + $cart_item["qty"];   
                }
            }
            $_SESSION["Cart_qty"] = $total;
            
            //redirect back to original page
            header('Location:'.$return_url);
        }


        // ------------------------------------------------------
        // BEGIN CHECKING WHAT KIND OF GET REQUEST IT IS

        //empty cart 
        if(isset($_GET["emptycart"]) &&  $_GET["emptycart"]==1)
        {
            empty_cart();
            countProducts();
        }

        //remove item from shopping cart
        else if(isset($_GET["removep"]) && isset($_GET["return_url"]) && isset($_SESSION["cart_items"]))
        {
            removep();
            countProducts();
        }

        //change a quantity of a specified product
        else if(isset($_GET["setQtyp"]) && isset($_GET["return_url"]) && isset($_GET["newQty"]) && isset($_SESSION["cart_items"])){
            setQtyp();
            countProducts();
        }

        //add a product to the cart
        else if(isset($_GET["addProduct"]) && isset($_GET["return_url"])) {
            //addProduct will check this time if the cart_items is set
            addProduct();
            countProducts();
        }

        //just update the number in the cart
        else if(isset($_GET["countProducts"])){
            countProducts();   
        }

        //None of these
        else if(isset($_GET["return_url"])){
            $return_url = base64_decode($_GET["return_url"]); //return url
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