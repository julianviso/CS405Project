<!--
Purchase.php
Purpose:
    Allows a custumer to view their shopping cart and click "Purchase" to buy the items it contains.
Preconditions:
    The customer clicks on the shopping cart to view this page.
    The customer may or may not have items in the cart already.
Postconditions:
    If the customer is not known, display a message telling them to log in.
    Else if there are no items in the cart, say it is empty.
    Else generates an Order entry when they click purchase (via cart_purchase.php.
-->
<!DOCTYPE html>

<html>
    <head>
    <title> Purchase </title>
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
            //current URL of the Page. cart_update.php redirects back to this URL

            function showCartContents() {
                $current_url = base64_encode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

                $total = 0;
                echo '<div class="manage_cart">';
                //echo '<form id="cart_table" action="cart_purchase.php" method="GET">';
                echo '<table>';
                echo 
                    '<tr>
                        <td>PRODUCT NAME</td>
                        <td>PRODUCT ID</td>
                        <td>QTY</td>
                        <td>PRICE EACH</td>
                        <td>SUBTOTAL</td>
                    </tr>';
                foreach ($_SESSION["cart_items"] as $cart_item){
                    echo '<tr>';
                    echo '<td>'.$cart_item["name"].'</td>';
                    echo '<td>'.$cart_item["prod_id"].'</td>';
                    $q = $cart_item["qty"];
                    echo 
                        '<td>'.$q.'
                        <span class="decrement_qty">
                        <a href="cart_update.php?setQtyp=
                            '.$cart_item["prod_id"].'
                            &return_url='.$current_url.'
                            &newQty='.($q-1).'">&minus;
                        </a></span>
                        
                        <span class="increment_qty">
                        <a href="cart_update.php?setQtyp=
                            '.$cart_item["prod_id"].'
                            &return_url='.$current_url.'
                            &newQty='.($q+1).'">&plus;
                        </a></span></td>';
                    echo '<td>'.$cart_item["price"].'</td>';

                    $subtotal = ($cart_item["price"] * $cart_item["qty"]);
                    $total = ($total + $subtotal);
                    
                    echo '<td>'.$total.'</td>';
                    echo '<td><span class="remove-item">
                        <a href="cart_update.php?removep=
                        '.$cart_item["prod_id"].'&return_url=
                        '.$current_url.'">&times;
                        </a></span></td>';
                    echo '</tr>';
                }
            echo '<tr><td colspan="5">
                <strong>
                    Total : $'.$total.'
                </strong></td></tr>';
            echo '</table>';
            echo '<a href="cart_purchase.php">';
            echo '<button type="button">PURCHASE</button>';
            echo '</a>';
            //echo '</form>;
            echo '</div>';
            echo '<br />';
                
            echo '<span class="empty-cart">
                    <a href="cart_update.php?emptycart=1&return_url='.$current_url.'">
                    <button type="button">
                    Empty Cart
                    </button></a>
                  </span>';
            }



            if(isset($_SESSION["cart_items"])){
                showCartContents();   
            }
            else{
                //showCartContents();
                echo 'Your cart is empty.';   
            }

            include "components/footer.html";
        ?>
    </body>