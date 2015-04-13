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
            unset($_SESSION["cart_items"]);
            $_SESSION["cart_qty"] = 0;
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
            $prod_id = $_GET["removep"]; //get the product prod_id to remove
            $return_url = base64_decode($_GET["return_url"]); //get return url

            foreach ($_SESSION["cart_items"] as $key => $cart_item) {
                if($cart_item["prod_id"]==$prod_id){
                    $temp = $_SESSION["cart_items"];
                    unset($temp[$key]);
                    $_SESSION["cart_items"] = $temp;
                }
            }


        }

        /**
        * setQtyp
        * Purpose:
        *   Changes the quantity of a given product from the cart.
        * Preconditions:
        *   $_SESSION["cart_items"] is initialized already.
        *   $_GET["setQtyp"] exists, and supplies the prod_id
        *   $_GET["newQty"] exists, and supplies the new quantity
        *   There is a return url to return to.
        * Postconditions:
        *   Decrements the quantity of an item by 1.
        *   If that sets the quantity to 0, removes it from the cart.
        */
        function setQtyp(){
            $prod_id = $_GET["setQtyp"]; //get the product prod_id to remove
            $newQty = $_GET["newQty"];
            $return_url = base64_decode($_GET["return_url"]); //get return url

            foreach ($_SESSION["cart_items"] as $key => $cart_item) {
                if($cart_item["prod_id"]==$prod_id){
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

        }

        /**
        * addProduct
        * Purpose:
        *   Adds an item to the cart.
        * Preconditions:
        *   $_SESSION["cart_items"] is initialized already.
        *   $_GET["addProduct"] exists, and supplies the prod_id
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
            $prod_id = $_GET["addProduct"]; 
            $newName = $_GET["newName"];
            $newQty = $_GET["newQty"];
            $newPrice = $_GET["newPrice"];
            $return_url = base64_decode($_GET["return_url"]); //get return url
            //Now put them into the new array
            $tempProduct = array();
            $tempProduct["prod_id"] = $prod_id;
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
            $tempCart[$prod_id] = $tempProduct;
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
        *   Updates $_SESSION["cart_qty"]
        */
        function countProducts(){
            $total = 0;
            if(isset($_SESSION["cart_items"])){

                foreach ($_SESSION["cart_items"] as $cart_item) {
                    $total = $total + $cart_item["qty"];   
                }
            }
            $_SESSION["cart_qty"] = $total;
            

        }

?>