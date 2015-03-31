<!--
Orders.php
Purpose:
    Allows a custumer to view their product orders.
Preconditions:
    The customer clicks on the orders link to view this page.
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
            include "components/header_top.html";
            include "components/header_menu.html";
        ?>
        
    </head>
    <body>
        
        <!--
            $_SESSION maintains a user's information across pages until they close the browser.
        -->
        <?php
        if (!isset($_SESSION["CID"])) {
            //header("location: index.php");
            //exit();
        }
    

        include "components/footer.html";
        ?>
        
    </body>
</html>