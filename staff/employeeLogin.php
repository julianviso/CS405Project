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
            require "../sql/serverinfo.php";
            include "../components/header_top.php";
            include "../components/header_menu.html"; 
        ?>
    
</head>
<body>

<?php
    session_start();
    if (isset($_SESSION["employee"])){
	   header("location: ../index.php");
	   exit();
    	}
?>
<?php
     //check for employee login: needs sid and password
     if (isset($_POST["sid"]) && isset($_POST["password"])){
          session_destroy(); //get rid of any current sessions running.
          session_start(); //start new session
          $sid = preg_replace('#[A-Za-z0-9]#i', '', $_POST["sid"]); //filter everything except numbers, and letters
          $password = preg_replace('#[A-Za-z0-9]#i', '', $_POST["password"]); //filter everything except numbers, and letters
          require_once('../php/mysqli_connect.php');
          $queryManager = "SELECT manager
                              FROM Staff
                              WHERE manager = 1 LIMIT 1";
          $stmt = mysqli_prepare($connected, $queryManager);
          
     }
     else{
          echo 'Login incorrect. <a href="../index.php">Click to go back to home page</a>';    
     }
?>  
    
    <div class="login_panel">
        	<h3>Staff Login</h3>
        	<p>Sign in with the form below.</p>
        	<form action="employeelogin.php" method="post" id="login" name="login">
                	<input type="text" value="sid(sid)" name=sid class="field" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'sid';}">
                    <input type="password" value="Password" name=password class="field" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}">
				<div class="buttons"><div><button type="login" name="login">Staff Log In</button></div></div>
          </form>   
        </div>
    
    
</body>  
</html>