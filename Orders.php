<!--
Orders.php
Purpose:
    Allows a custumer to view their product orders.
Preconditions:
    The customer clicks on the orders link to view this page.
    The customer can choose to view order details.
Postconditions:
    If the customer is not known, display a message telling them to log in.
    Else if there are no orders, say so.
    Else display all of their orders.
-->
<!DOCTYPE html>

<html>
    <head>
    <title> Orders </title>
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
            require "sql/serverinfo.php";
            include "components/header_top.php";
            include "components/header_menu.html"; 
        ?>
    </head>
    <body>
        
    <!--
        $_SESSION maintains a user's information across pages until they close the brex.phpowser.
        Redirect if the email is not known to the PleaseLogin page.
    -->
    <?php

        if (!isset($_SESSION["email"])) {
            header("location: PleaseLogin.php");
            exit();
        }

    //Connect to the database
    $link = mysqli_connect($host, $login, $password, $dbname);
    

    //Query for the Orders corresponding to this session user
    $query_string = 
        "SELECT *
        FROM Orders
        WHERE email = '".$_SESSION['email']."'";

    //Get the query
    $response = mysqli_query($link, $query_string);
    $num_rows = mysqli_num_rows($response);
    if ($num_rows == 0){
        //Handle empty orders, etc.
        echo '<h3>You have no orders on record.</h3>';
    }

    //Repeatedly display each order
    while($row = mysqli_fetch_array($response)){
        //Table header
        $order_id = $row["order_id"];
        echo '<form name="orders" method="post" action="order_details.php">';
        echo '<div class="orders">';
        echo "<h3>ORDER # ".$order_id."</h3>";
        echo '<table class="zebra">';
        echo '
            <tr>
                <td align="left">ORDER</td>
                <td align="left">SHIP STATUS</td>
                <td align="left">DATE ORDERED</td>
                <td align="left">DATE SHIPPED</td>
                <td align="left">TOTAL</td>
            </tr>';
        
        //Table body
        //NOTE: order_id is sent via POST to order_details.php
        echo
            '<tr>
                <td><input type="text" name="order_id" value="'.$row['order_id'].'" class="order_id" readonly></input></td>
                <td>';
            if ($row['status'] == 0){
                echo 'PENDING';
            }
            else {
                echo 'SHIPPED';
            }
                echo '</td>
                <td>'.$row['orderDate'].'</td>
                <td>'.$row['shippingDate'].'</td>
                <td>'.$row['total'].'</td>
                <td>
                    <div class="button">
                    <button name="TEST">Details</button>
                    </div>
                </td>
            </tr>';
        echo '</table><br/></div></form>';

    } 
 

    mysqli_close($connection);
    include "components/footer.html";
    ?>
        
    </body>
</html>