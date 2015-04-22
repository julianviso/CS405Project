<!--
cart_purchase.php
Purpose:
    Processes a purchase made from Purchase.php.
Preconditions:
    The customer clicks on the purchase button from the Purchase page.
    The customer may or may not have items in the cart already.
Postconditions:
    If the customer is not known, display a message telling them to log in.
    Else if there are no items in the cart, say it is empty.
    Else generates an Order entry when they click purchase.
-->
<!DOCTYPE html>

<html>
    <head>
    <title> Processing Purchase ... </title>
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
            
            //Has all the functions for updating the cart
            include "cart_functions.php";

            //Now checks to make sure a customer is logged in
            if (!isset($_SESSION["email"])) {
                header("location: PleaseLogin.php");
                exit();
            }



        ?>
    </head>
    <body>
        <?php

            /**
            * createOrder()
            * Purpose:
            *   Creates an Order from the next auto_increment, user's email,
            *   and current date.
            * Preconditions:
            *   $link is the connection to the database,
            *       e.g. $link =  mysqli_connect($conn, $login, $password, $dbname);
            *   $_SESSION["email"] must be initialized.
            *   
            * Postconditions:
            *   An Order row in the database.
            *   Note: after this function returns, the total is initially 0, because 
            *   items aren't added up yet (nor created in orderlines).
            *   Returns the ID number of the Order.
            */
            function createOrder($link){
                $result = mysqli_query($link, "
                        SELECT AUTO_INCREMENT 
                        FROM information_schema.tables
                        WHERE table_name = 'Orders' 
                        AND table_schema = DATABASE()
                    ");
                $data = mysqli_fetch_array($result);
                //Now give thisOrder_id the next num
                $thisOrder_id = $data["AUTO_INCREMENT"];
                if ($data == null){
                    echo "Something went wrong in createOrder, data is null";
                   $thisOrder_id = 1;   
                }


                echo "Created new Order $thisOrder_id <br \><br \>";
                
                $date = time();
                $email = $_SESSION["email"];
                $date = date( 'Y-m-d H:i:s', $date );
                
                //Insert into database
                mysqli_query ($link, 
                    "INSERT INTO Orders values
                    ('$thisOrder_id', '$email', 
                     0, null, '$date', 0)
                    ");
                //mysql errors here
                if (mysqli_error($link)){
                    echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                    return -1;
                }
                return $thisOrder_id;
            }

            /**
            * countProducts()
            * Purpose:
            *   Creates an Order from the items in the user's cart if there
            *   are valid items.  
            * Preconditions:
            *   $_SESSION["cart_items"] may or may not be initialized.
            *   
            * Postconditions:
            *   Totals the price of the order and inserts rows into orderlines
            *   for each item added to the order.
            *   Updates the database with how many items are remaining.
            */
            function makePurchases(){
                global $conn, $login, $password, $dbname;

                
                if (!isset($_SESSION["cart_items"])){
                    return;
                }
                $email = $_SESSION["email"];
                
                $created_order = false;
                $order_id = -1;
                $order_total = 0;

                //Connect to the database.
                $link = mysqli_connect($conn, $login, $password, $dbname);
                if (mysqli_error($link)){
                    echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                    return 0;
                }
                
                //Process each item in the cart
                foreach ($_SESSION["cart_items"] as $item){
                    $prod_id = -1;
                    $name = "";
                    $price = 0;
                    $qty = 0;
                    
                    
                    //Check that the cart item has all fields
                    //If so escape them to avoid character problems
                    //mysql_real_escape_string
                    if (isset($item["prod_id"])){
                        $prod_id = $item["prod_id"];    
                    }
                    if (isset($item["name"])){
                        $name = ($item["name"]);   
                    }
                    if (isset($item["price"])){
                        $price = ($item["price"]);
                    }
                    if (isset($item["qty"])){
                        $qty = ($item["qty"]);   
                    }
                    
                    
                    //Determine if the product doesn't exist in db
                    $str_prod_id = (string)$prod_id;
                    $query =    'SELECT * FROM Products 
                                WHERE prod_id='.$str_prod_id;
                    $result = mysqli_query($link, $query);
                    if (mysqli_error($link)){
                        echo $prod_id.'<br/>';
                        echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                        return 0;
                    }
                    $row_nums = mysqli_num_rows($result);
                    if ($row_nums < 1){
                        echo 'Error: There is no product with ID number: '.$item["prod_id"].'<br/>';   
                    }
                    else {//Else this product ID does exist

                        //Should have just a single row here, no duplicates
                        $dbrow = mysqli_fetch_array($result);
                        //echo "qty: ";
                        //echo $dbrow["qty"];        

                        if ($dbrow["qty"] == 0){
                            echo "Our ".$name. " stock is empty, none added to your order.<br/>";
                        }
                        else{
                            //Create a new Order if for the first time
                            if (!$created_order){
                                $created_order = true;
                                $order_id = createOrder($link);
                            }
                            $newQty = $dbrow["qty"] - $qty;
                            if ($newQty < 0){
                                $qty = $qty + $newQty; //to Orderlines
                                $newQty = 0; //updates Products
                            }
                            //echo $qty.'<br/>';
                            
                            //Add this item to the Orderline table
                            $query =    "INSERT INTO Orderlines values
                                        ('$order_id', '$prod_id', '$qty')
                            ";
                            $result = mysqli_query($link, $query);
                            if (mysqli_error($link)){
                                echo $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                            }
                            
                            //Getting the discount
                            $today_date = strtotime("now");
                            $today_date = date('Y-m-d', $today_date);
                            $discount_query = "SELECT DISTINCT *
                                      FROM Promotions
                                      WHERE prod_id='$prod_id'
                                      AND startDate < '$today_date'
                                      AND endDate > '$today_date'";
                            
                            $discount_result = mysqli_query($link, $discount_query);
                            if (mysqli_error($link)){
                                echo $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                            }
                            $discount = 0;

                            while($discount_data= mysqli_fetch_array($discount_result) ) {
                                $discount = $discount_data["discount"];
                            }
                            
                            //Accumulate the total so far
                            $query =    'SELECT * FROM Products 
                                         WHERE prod_id=
                                         ' .$str_prod_id;
                            $result = mysqli_query($link, $query);
                            $dbrow = mysqli_fetch_array($result);
                            $order_total = $order_total + (int)($dbrow["price"]) * $qty - (int)($dbrow["price"]) * $qty * $discount;
                            
                            //Update the total in database
                            $query =    "UPDATE Orders
                                        SET total='$order_total'
                                        WHERE order_id='$order_id'";
                            $result = mysqli_query($link, $query);
                            if (mysqli_error($link)){
                                    echo $prod_id.'<br/>';
                                    echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";

                            }
                            //echo $order_total;
                            echo "<br/>";
                        }
                        
                    }
                
                }
                print "<p>Total: ".$order_total."</p>";
                
                
                
                mysqli_close($link);
                return 0;
            }
                        
            $error = makePurchases();
            empty_cart();
            //echo "<br \>Something went wrong with processing your purchase.  Please <a href=\"Purchase.php\">try again</a>. <br \><br \>";
            echo "<a href='$host./Orders.php'><button>VIEW ALL ORDERS</button><a/>";

            include "components/footer.html";
        ?>
    </body>
</html>