<!DOCTYPE HTML>
<head>
<title><?php echo $_GET['interval'] Date?></title>
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
            if(isset($_SESSION["email"]) && $_SESSION["manager"] == 1){
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
	<a href="viewStatistics.php?interval=7">7 Days</a> | <a href="viewStatistics.php?interval=30">30 Days</a> | <a href="viewStatistics.php?interval=365">365 Days</a>
	<?php
		require "../sql/serverinfo.php";
		//Get orders of items and check that order date is in range (now to chosen interval)
		//NOW() = return current date and time
		//DAY() = synonym for DAYOFMONTH(date) which returns the day of the month for date
		$query = "SELECT *	
				FROM Orders, Products, Orderlines
				WHERE Orders.order_id = Orderlines.order_id AND Products.prod_id = Orderlines.prod_id
					AND Orders.orderDate BETWEEN NOW() - INTERVAL ".$_GET['interval']." DAY AND NOW()
				GROUP BY Orders.order_id";
		$link = mysqli_connect($conn, $login, $password, $dbname);
		$result = mysqli_query($link, $query);
		$revenue = 0;
		if ($result){
			echo '<tr><td align="center"><b>prod_id</b></td>
				<td align="center"><b>price</b></td>
				<td align="center"><b>qty</b></td>
				<td align="center"><b>total</b></td></tr>';
			while ($row = mysqli_fetch_array($result)){
				$qty = $row["SUM(Product.qty)"];
				$price = $row['price'];
				$total = $qty * $price;
				$revenue += $total;
				echo '<tr><td>'.$row['prod_id'].'</td>
					<td align="center">'.$row['price'].'</td>
					<td align="center">'.$row['SUM(Product.qty)'].'</td>
					<td align="center">'.$total.'</td>
					<td align="center">';
				echo '</tr>';
			}
			echo "Revenue gained in the last ".$_GET['interval']." Days: ".$revenue;
			echo '</table>';
		}
		else{
			echo "Some error happened";	
		}
	?>
</body>
</html>