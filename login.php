<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->

<!DOCTYPE HTML>
<head>
<title>Free Smart Store Website Template | login :: w3layouts</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/slider.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/menu.css" rel="stylesheet" type="text/css" media="all"/>
<link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script> 
<script type="text/javascript" src="js/nav.js"></script>
<script type="text/javascript" src="js/nav-hover.js"></script>
<script type="text/javascript">
  $(document).ready(function($){
    $('#dc_mega-menu-orange').dcMegaMenu({rowItems:'4',speed:'fast',effect:'fade'});
  });
</script>
    
        <?php
            require "sql/serverinfo.php";
            include "components/header_top.php";
            include "components/header_menu.html"; 
        ?>
    
</head>
<body>
	
	<?php
		//If the user tries to create a new account and hits the register button.
		if (isset($_POST['register'])){
			$missingData = array();

			if (empty(isset($_POST['firstName'])))
			{
				//if first name is not found when register button gets clicked add to the array the information that's missing
				//Else remove any whitespace that the user may have entered in the first name
				echo "Missing first name!";
				$missingData[] = 'First Name'; 
			}	
			else
			{
				$fname = trim($_POST['firstName']);
			}

			if (empty(isset($_POST['lastName'])))
			{
				//if last name is not found when register button gets clicked add to the array the information that's missing
				//Else remove any whitespace that the user may have entered in the last name
				echo "Missing last name!";
				$missingData[] = 'Last Name'; 
			} else
			{
				$lname = trim($_POST['lastName']);
			}

			if (empty(isset($_POST['email'])))
			{
				echo "Missing email!";
				$missingData[] = 'email'; 
			} 
			else
			{
				$custEmail = trim($_POST['email']);
			}

			if (empty(isset($_POST['password'])))
			{
				echo "Missing password";
				$missingData[] = 'password';
			}
			else
			{
				$custPassword = trim($_POST['password']);
			}

			//If there is no missing data in array put the data in the customers table and echo that the account was created.
			if(empty($missingData))
			{
        		//require_once('web/php/mysqli_connect.php');
                $connected = mysqli_connect($conn, $login, $password, $dbname);
        		$query = "INSERT INTO Customers values 
                    ('$custEmail', '$fname', 
                     '$lname', '$custPassword')";
				$result = mysqli_query($connected, $query);
				if (mysqli_error($link)){
                        echo $prod_id.'<br/>';
                        echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                }
                else {
                        echo "WELCOME!  Created your account successfully!";
                }
                mysqli_close($connected);
                
                /**
                mysqli_stmt_bind_param($stmt, 'ssss', $email, $fname,$lname, $password);
        			mysqli_stmt_execute($stmt);
        			$affected_rows = mysqli_stmt_affected_rows($stmt);
        		if($affected_rows == 1){
            			echo 'Account Created';
            			mysqli_stmt_close($stmt);
            			mysqli_close($connected);
				}	
				else{
					echo 'Error<br/>';
					echo mysqli_error();
					mysqli_stmt_close($stmt);
					mysqli_close($connected);
				}
                */
			}
			//If there is missing data, echo back what is missing and needs to be entered.
			//else{
				//echo 'Following data is missing:<br />';
        		//	foreach($missingData as $missing){
            	//		echo "$missing<br/>";
				//}
	//		}
		}
	?>
	
	<?php
		//if user tries to use the login page. Parses to check for both email, and password entered correctly after login button is pressed.
		if (isset($_POST['login'])){
			$missingData = false;
			//$email = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["email"]); // filter everything but numbers and letters
            //$password = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password"]);
			
			if (!(isset($_POST['email'])))
			{
				echo "Missing email!";
				$missingData = true; 
			} 
			else
			{
				$custEmail = trim($_POST['email']);
			}
			if (!(isset($_POST['password'])))
			{
				echo "Missing password";
				$missingData = true;
			}
			else{
				$pass = trim($_POST['password']);
			}
			if (!$missingData)
			{
                /*
				require_once('web/php/mysqli_connect.php');
				$query= "SELECT fname 
						FROM Customers 
						WHERE email = ? AND password = ? LIMIT 1";
				$stmt = mysqli_prepare($connected, $query);
				mysqli_stmt_bind_param($stmt, 'is', $email, $password);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt, $fname);
				mysqli_stmt_store_result($stmt);
                */
                $connected = mysqli_connect($conn, $login, $password, $dbname);
        		$query = "SELECT DISTINCT * 
                          FROM Customers
                          WHERE email='$custEmail' 
                           AND password='$pass'";
				$result = mysqli_query($connected, $query);
                
				if (mysqli_error($link)){
                    echo $prod_id.'<br/>';
                    echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                }
				//Determine if user exists in database.
                $row_nums = mysqli_num_rows($result);
                $userExists = $row_nums;
                
                //echo "Got ".$row_nums." from db table<br/>";
				//Returns a 1 if true, 0 otherwise.
				//$userExists = mysqli_stmt_num_rows($stmt); 
				if ($row_nums != 0) 
				{
					mysqli_stmt_fetch($stmt);
					$_SESSION["email"] = $custEmail;
					$_SESSION["password"] = $pass;
                    
                    echo '<h3>WELCOME '.$_SESSION["email"].'!</h3><br/>';
					//mysqli_stmt_close($stmt);
	 				mysqli_close($connected);
                    
                    include "components/footer.html";
                    //THE FILE IS DONE HERE -- NO MORE EXECUTION
					exit();
				}
				else{
					echo '<h3>Incorrect login. <a href="login.php">Go Back?</a></h3>';
                    include "components/footer.html";
                    //ANOTHER POSSIBLE EXIT HERE
                    //NO MORE EXECUTION
					exit();
				}
			}
			else{
				echo 'Following data is missing:<br />';
        			foreach($missingData as $missing){
            			echo "$missing<br/>";
				}
			}
			
		}		
	?>
	
	
<div class="wrap">
 <div class="main">
    <div class="content">
    	 <div class="login_panel">
        	<h3>Existing Customers</h3>
        	<p>Sign in with the form below.</p>
        	<form action="login.php" method="post" id="login" name="login">
                	<input type="text" value="Username (email)" name=email class="field" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email';}">
                    <input type="password" value="Password" name=password class="field" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}">
				<div class="buttons"><div><button type="login" name="login">Sign In</button></div></div>
          </form>
          <p class="note">If you forgot your password just enter your email and click <a href="#">here</a></p>
                    
        </div>
        
        
    	<div class="register_account">
    		<h3>Register New Account</h3>
    		<form action="login.php" method="post" id="register1" name="register1">
		   	<table>
		   		<tbody><tr><td><div><input type="text" name="firstName" value="firstName" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'First Name';}" ></div>
		    			<div><input type="text" name="lastName" value="lastName" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Last Name';}"></div>
		    			<div><input type="text" name="email" value="E-Mail" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'E-Mail';}"></div>
		    			<div><input type="text" name="password" value="password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'password';}"></div>
		    			 </td>
		    			<td></td>
		    		</tr> 
		    		</tbody>
			</table> 
			<!--
		   <div class="search">< div><button class="grey">Create Account</button></div></div> -->
			<div class="search"></div><button type="register" value='register' name="register" >Create Account</button></div></div>
		    <p class="terms">By clicking 'Create Account' you agree to the <a href="#">Terms &amp; Conditions</a>.</p>
		    <div class="clear"></div>
		</form>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
</div>

<?php
    include "components/footer.html";
?>

</body>
</html>

