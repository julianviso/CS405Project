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
        session_start();
        if (!isset($_SESSION["email"])) {
            //header("location: PleaseLogin.php");
            //exit();
        }

    //Query for the Orders corresponding to this session user
    $query_string = 
        "SELECT DISTINCT order_id, status, shippingDate, orderDate,
        FROM Orders
        WHERE email = '".$_SESSION['email']."'";

    //Connect to the database
    $connection = mysqli_connect($host, $login, $password, $dbname);
    //Get the query
    $db_stmnt = @mysqli_query($connection, $query_string);

    if($response){
        //Table header
        echo '<table>';
        echo
            '<tr>
                <td align="center">ORDER</td>
                <td align="center">SHIP STATUS</td>
                <td align="center">DATE ORDERED</td>
                <td align="center">DATE SHIPPED</td>
                <td align="center">TOTAL</td>
            </tr>';
        
        while ($this_row = mysqli_fetch_array($db_stmnt)){
            $total = '0';

            //Concatenation is done with . in php            
            echo
                '<tr>
                    <td>'.$row['order_id'].'</td>
                    <td>'.$row['status'].'</td>
                    <td>'.$row['orderDate'].'</td>
                    <td>'.$row['shippingDate'].'</td>
                    <td>'.$row['total'].'</td>
                    <td>Details</td>
                </tr>';
            //TODO: add a link at the end of each row for order details.
        }
        echo '</table>';
    } else {
        //Handle empty orders, etc.
        echo '<h3>You either have no orders, or query is malformed.</h3>';
    } 

    mysqli_close($connection);
    include "components/footer.html";
    ?>
        
    </body>
</html>