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
        $_SESSION maintains a user's information across pages until they close the browser.
        Redirect if the email is not known to the PleaseLogin page.
    -->
    <?php

        if (!isset($_SESSION["email"])) {
            header("location: PleaseLogin.php");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            //Get the order id from the post data
            $int_oid =  (int)$_POST["order_id"];
            
            //Connect to the database and get the order contents
            $link = mysqli_connect($host, $login, $password, $dbname);
            $query_string = 
                "SELECT *
                FROM Orderlines
                WHERE order_id='$int_oid'
                ";
            $response = mysqli_query($link, $query_string);
            $num_rows = mysqli_num_rows($response);
            if ($num_rows == 0){
                echo '<h3>This order is empty.</h3>';
                //EXIT HERE
                include "components/footer.html";
                exit();
            }
            
            //Table header
            echo '<h3>ORDER #'.$_POST["order_id"].'</h3>';
            echo '<div class="orderlines"><table class="bordered">
                    <tr>
                        <td>PRODUCT NAME</td>
                        <td>QUANTITY</td>
                        <td>PRODUCT ID #</td>
                    </tr>
                ';
            while($orderline_row = mysqli_fetch_array($response)){
                $int_pid = (int)$orderline_row["prod_id"];
                $name_query =
                    "SELECT name
                    FROM Products
                    WHERE prod_id='$int_pid'";
                //If the earlier rows existed, this one has to exist
                //since it is a foreign key.
                $name_response = mysqli_query($link, $name_query);
                $product_row = mysqli_fetch_array($name_response);
                
                echo '
                    <tr>
                        <td>'.$product_row["name"].'</td>
                        <td>'.$orderline_row["quantity"].'</td>
                        <td>'.$int_pid.'</td>
                    </tr>';
            }
            
            if (mysqli_error($link)){
                echo $prod_id.'<br/>';
                echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
            }
            
            echo '</table></div>';
            
            mysqli_close($connection);
        }
        
        
        include "components/footer.html";
    ?>
        
    </body>
</html>