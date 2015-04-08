<?php
    session_start();
    if (isset($_SESSION["employee"])){
	   header("location: index.php");
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
    