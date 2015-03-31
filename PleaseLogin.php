<!--
PleaseLogin.php
Purpose:
    Informs the user that they need to log in when they try to access a page that they are not currently authorized to view.
Preconditions:
    The customer clicks on a link to view this page.
Postconditions:
    Display error message.
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
        <h1>You are not logged in.</h1>
        <p>Please <a href="login.php">log in</a> to view that page.  <br /><br /></p>
        
        
        <?php
        include "components/footer.html";
        ?>
        
    </body>
</html>