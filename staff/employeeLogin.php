<!DOCTYPE HTML>
<head>
<title>Free Smart Store Website Template | login :: w3layouts</title>
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
            if(isset($_SESSION["manager"]) && $_SESSION["manager"] == 1){
            }
            else{
            }
        ?>
    
</head>
<body>

<?php
    //check for employee login: needs sid and password
    if (isset($_POST["email"]) && isset($_POST["password"])){
        session_destroy(); //get rid of any current sessions running.
        session_start(); //start new session
        //$sid = preg_replace('#[A-Za-z0-9]#i', '', $_POST["sid"]); //filter everything except numbers, and letters
        //$password = preg_replace('#[A-Za-z0-9]#i', '', $_POST["password"]); //filter everything except numbers, and letters
        $email = $_POST["email"];
        $password = $_POST["password"];
        //require_once('../php/mysqli_connect.php');
        $connected = mysqli_connect($conn, $login, $password, $dbname);

        $query = "SELECT DISTINCT * 
                   FROM Staff
                   WHERE email='$email' AND password='$password'";
        $result = mysqli_query($connected, $query);
        //Determine if user exists in database.
        $row_nums = mysqli_num_rows($result);
        $userExists = $row_nums;

        $found = false;
        if ($row_nums != 0){
            $found = true;
            $_SESSION["staff"] = 1;
            include "../components/staffHeader_menu.html";   

        }

        $query = "SELECT DISTINCT *
                    FROM Managers
                    WHERE email='$email' 
                    AND password='$password'";
        $result = mysqli_query($connected, $query);
        $row_nums = mysqli_num_rows($result);
        if ($row_nums != 0){
            $found = true;
            $_SESSION["manager"] = 1;
            include "../components/managerHeader_menu.html";

        }

        if ($found) 
        {
            mysqli_stmt_fetch($stmt);
            $_SESSION["email"] = $email;
            $_SESSION["password"] = $password;
               echo '<h3>WELCOME '.$_SESSION["email"].'!</h3><br/>';
            mysqli_close($connected);          
               include "../components/footer.html";
            exit();
        }
        else{
            echo '<h3>Incorrect login. <a href="employeeLogin.php">Go Back?</a></h3>';
               include "../components/footer.html";
            exit();
        }
	} 
?>  
    
    <div class="login_panel">
        	<h3>Staff Login</h3>
        	<p>Sign in with the form below.</p>
        	<form action="employeeLogin.php" method="post" id="login" name="login">
                	<input type="text" value="email" name=email class="field" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'sid';}">
                    <input type="password" value="Password" name=password class="field" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}">
				<div class="buttons"><div><button type="login" name="login">Staff Log In</button></div></div>
          </form>   
        </div>
    
    
</body>  
</html>