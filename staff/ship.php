<!--
update_inventory.php
Purpose:
    Same as view inventory, but with editable text boxes to change the quantity of any component.
-->
<!DOCTYPE HTML>

<head>
<title>View Inventory</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="../css/slider.css" rel="stylesheet" type="text/css" media="all"/>
<link href="../css/menu.css" rel="stylesheet" type="text/css" media="all"/>
<link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../js/move-top.js"></script>
<script type="text/javascript" src="../js/easing.js"></script> 
<script type="text/javascript" src="../js/nav.js"></script>
<script type="text/javascript" src="../js/nav-hover.js"></script>
<script type="text/javascript">
  $(document).ready(function($){
    $('#dc_mega-menu-orange').dcMegaMenu({rowItems:'4',speed:'fast',effect:'fade'});
  });
</script>
    
    <?php
        session_start();
        require "../sql/serverinfo.php";
        if($_SESSION["manager"] == 1){
            //if employee is a manager
            include "../components/managerHeader_menu.html";
        }
        else{
            //else if normal employee
            include "../components/staffHeader_menu.html"; 
        }
    ?>
</head>
<body>
    
    <?php
        /**
        * shipOrder()
        * Purpose:
        *   Changes an order's status to shipped.
        * Preconditions:
        *   The following must exist:
        *   $_POST["order_id"]
        * Postconditions:
        *   Updates the order table in the database to 'shipped'
        */
        function shipOrder(){
            global $host, $login, $password, $dbname;
            $link = mysqli_connect($host, $login, $password, $dbname);
            $order_id = (int)($_POST["order_id"]);

            //Set the ship date to today
            $date = time();
            $email = $_SESSION["email"];
            $date = date( 'Y-m-d H:i:s', $date );
            mysqli_query ($link, "UPDATE Orders
                                  SET shippingDate='$date'
                                  WHERE order_id='$order_id'");
            
            //Set the status to 1 meaning SHIPPED
            $query_string = "UPDATE Orders
                             SET status=1
                             WHERE order_id='$order_id'";
            
            
            $response = mysqli_query($link, $query_string);
            if (mysqli_error($link)){
                echo $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
            }
            //All the details of this order
            $orderlines_query = "SELECT *
                    FROM Orderlines
                    WHERE order_id='$order_id'";
            $line_response = mysqli_query($link, $orderlines_query);
            if (mysqli_error($link)){
                echo $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
            }
            //Removing items from the database
            while($dbrow = mysqli_fetch_array($line_response)){

                $prod_id = $dbrow["prod_id"];
                $prod_query = "SELECT * 
                               FROM Products
                               WHERE prod_id='$prod_id'";
                $prod_result = mysqli_query($link, $prod_query);
                if (mysqli_error($link)){
                    echo $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                }
                // Update the correct quantities in the order
                // based on what is available and how many the
                // customer wants.
                $prod_row = mysqli_fetch_array($prod_result);
                $prod_qty = $prod_row["qty"];
                $cust_qty = $dbrow["quantity"];
                
                $old_cust_qty = $cust_qty;
                if ($prod_qty < $cust_qty){
                    $cust_qty = $prod_qty;
                    $prod_qty = 0;
                }
                else {
                    $prod_qty = $prod_qty - $cust_qty;   
                }
                
                // Determine if the customer should be refunded.
                $diff_qty = $old_cust_qty - $cust_qty;
                $refund = 0;
                if ($diff_qty != 0){
                    $query =    "SELECT * 
                                 FROM Products
                                 WHERE prod_id='$prod_id'";
                    $result = mysqli_query($link, $query);
                    $temp = mysqli_fetch_array($result);
                    
                    $refund = $diff_qty * (int)$temp["price"];
                    
                    //Update the new total
                    $query =    "SELECT * FROM Orders
                                 WHERE order_id='$order_id'";
                    $result = mysqli_query($link, $query);
                    $temp = mysqli_fetch_array($result);
                    $total = (int)$temp["total"] - $refund;
                    
                    $query =    "UPDATE Orders
                                 SET total='$total'
                                 WHERE order_id='$order_id'";
                    $result = mysqli_query($link, $query);
                }
 
                //Update the database quantities
                $query =    "UPDATE Products
                            SET qty='$prod_qty' 
                            WHERE prod_id='$prod_id'";
                $result = mysqli_query($link, $query);
                
                $query =    "UPDATE Orderlines
                            SET quantity='$cust_qty'
                            WHERE order_id='$order_id'";
                $result = mysqli_query($link, $query);
                
                //May need to update the total as well.

            }
            mysqli_close($link);              
        }
            
            

            
        



        //Check if this is a post request, and if so ship.
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            if (isset($_POST["order_id"]) && ($_POST["order_id"] != "")){
                shipOrder();
            }
        }

        $link = mysqli_connect($host, $login, $password, $dbname);
        $query_string = "SELECT * 
                         FROM Orders
                         WHERE status = 0";
        $response = mysqli_query($link, $query_string);
        $num_rows = mysqli_num_rows($response);
        if ($num_rows == 0){
            echo "<h3>There are no pending orders.</h3>";
            exit(0);
        }


        echo "<h3>Pending Orders</h3>";

        
        while($row = mysqli_fetch_array($response)){
            $email = $row['email'];
            $order_id = $row['order_id'];
            $orderDate = $row['orderDate'];
            $total = $row['total'];
            
            //Top table header
            //Main order information
            echo '
                <form name="ship_order" method="post" action="ship.php">
                <div class="orderlines">

                <table class="bordered">
                <th colspan=4>Order</th>
                <tr>
                    <td align="left">ORDER ID</td>
                    <td align="left">CUSTOMER EMAIL</td>
                    <td align="left">ORDER DATE</td>
                    <td align="left">TOTAL</td>
                </tr>
                ';
            echo '
                <tr>
                    <td>'.$order_id.'</td>
                    <td><input name="order_id" type="hidden" value="'.$order_id.'"</input>'.$row['email'].'</td>
                    <td>'.$orderDate.'</td>
                    <td>'.$total.'</td>
                </tr></table>';

            
            //All the details of this order
            $orderlines_query = "SELECT *
                    FROM Orderlines
                    WHERE order_id='$order_id'";
            $line_response = mysqli_query($link, $orderlines_query);
            if (mysqli_error($link)){
                echo $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
            }
            
            echo '
                
                <div class="orderlines">
                <table class="bordered">
                <th colspan=4>Details:</th>
                <tr>
                    <td>PRODUCT ID #</td>
                    <td>NAME</td>
                    <td>QTY ORDERED</td>
                    <td>QTY IN STOCK</td>
                </tr>
                ';
            while($line_row = mysqli_fetch_array($line_response)){
                $prod_id = $line_row["prod_id"];
                $qty_ordered = $line_row["quantity"];
                
                $prod_query = "SELECT *
                    FROM Products
                    WHERE prod_id='$prod_id'";
                $prod_response = mysqli_query($link, $prod_query);
                $prod_row = mysqli_fetch_array($prod_response);
                $name = $prod_row["name"];
                $qty_left = $prod_row["qty"];
                
                echo '
                    <tr>
                        <td>'.$prod_id.'</td>
                        <td>'.$name.'</td>
                        <td>'.$qty_ordered.'</td>
                        <td>'.$qty_left.'</td>
                    </tr>';
            }

            echo '</table><input type="submit" name="Ship" value="Ship"></input></div></form><br /><br />';
            
        }
    ?>
</body>