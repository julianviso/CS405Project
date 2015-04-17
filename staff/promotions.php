<!DOCTYPE HTML>
<head>
<title>Staff/Employee Page</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="../css/slider.css" rel="stylesheet" type="text/css" media="all"/>
<link href="../css/menu.css" rel="stylesheet" type="text/css" media="all"/>
<link href="../bootstrap-3.3.2-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
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
                //keep temporarily, delete after
			  //include "../components/staffHeader_menu.html";
			  	echo "Not a manager.";
				header("location: ../index.php");
    				exit(); 
            }
		?>
        
    
</head>
<body>
	
	<?php
		 function addPromotion(){
            global $conn, $login, $password, $dbname;
            //Connect to the database.
            $err_message = null;
            $link = mysqli_connect($conn, $login, $password, $dbname);
            if (mysqli_error($link)){
                $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                return $err_message;
            }
            $discount = $_POST["discount"];
            $startDate = $_POST["startDate"];
            $endDate = $_POST["endDate"];
            //Update the quantity
            $query = "INSERT INTO Promotions VALUES
                      (DEFAULT, '$discount', '$startDate', '$endDate', DEFAULT, DEFAULT)";
            $result = mysqli_query($link, $query);
            if (mysqli_error($link)){
                $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
            }
            
            $result = mysqli_query($link, "
                        SELECT AUTO_INCREMENT 
                        FROM information_schema.tables
                        WHERE table_name = 'Promotions' 
                        AND table_schema = DATABASE()
                    ");
            $data = mysqli_fetch_array($result);
            //Now give thisOrder_id the next num
            $thisOrder_id = $data["AUTO_INCREMENT"];
            
            return $thisOrder_id - 1;
            
        }
		if(isset($_SERVER["REQUEST_METHOD"] =="POST" )){
			addPromotion();
			
		}
			/*
	       function updatePromotions(){
            global $conn, $login, $password, $dbname;
            //Connect to the database.
            $err_message = null;
            $link = mysqli_connect($conn, $login, $password, $dbname);
            if (mysqli_error($link)){
                $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                return $err_message;
            }
		  

            //Discount
            $query = 'UPDATE Promotions
                      SET discount='.$_POST["discount"].'
                      WHERE promo_id='.$_POST["promo_id"];
            $result = mysqli_query($link, $query);
            if (mysqli_error($link)){
                    $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
            }

            $row_nums = mysqli_num_rows($result);
            if ($row_nums < 1){
                $err_message = 'Error: There is no promo with ID number: '.$item["promo_id"].'<br/>';
            }

            mysqli_close($link);
            return $err_message;
        }
	   */


		require "../sql/serverinfo.php";
		$query = "SELECT *	FROM Products";
		$link = mysqli_connect($conn, $login, $password, $dbname);
		$result = mysqli_query($link, $query);
		if ($result){
			//this is ugly bootstrap it when project is closer to finished.
			echo '<tr><td align="center"><b>name</b></td>
			<td align="center"><b>prod_id</b></td>
			<td align="center"><b>price</b></td>
			<td align="center"><b>quantity (in stock)</b></td>
			<td align="center"><b>discount</b></td>
			<td align="center"><b>startDate</b></td>
			<td align="center"><b>endDate</b></td></tr>';	
			
			//mysqli_fetch_array returns one row from the query
			//while loop to get all the rows
			while ($row = mysqli_fetch_array($result)){
				echo '<tr><td align="center">' . $row['name'] . '</td>
				<td align="center">' . $row['prod_id'] . '</td>
				<td align="center">' . $row['price'] . '</td>
				<td align="center">' . $row['qty'] . '</td>';
				
				//Get the input and button for updating sale price
				echo '<form id=form'.$row['prod_id'].' method="post" action="promotions.php">
				
					<input type="hidden" name="prod_id" id="prod_id" value="'.$row['prod_id'].'"/>
					<input type="text" name="discount" id="discount"/>
					<input type="date" name="startDate"/>
					<input type="date" name="endDate"/>
					<input type="submit" name="discount" id="discount" value="Commit"/>
				</form></td>';
				echo '</tr>';
			}
		}
		else{
			echo "some kind of error happened";
		}

	
	?>
	
	
</body>
<footer>
</footer>
</html>