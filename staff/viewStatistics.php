<!DOCTYPE HTML>
<head>
<title>Staff/Employee Page</title>
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
        	  if($_SESSION["manager"] == 1){
            //if employee is a manager
            	include "../components/managerHeader_menu.html";
        	  }
			else{
				exit();
			}
		?>
	<?php
		//this is probably not correct yet, go back and do later.
		$query = "SELECT *
				FROM Products, Orderlines, Orders
				WHERE Products.prod_id = Orderlines.prod_id 
					AND Orders.order_id = Orderlines.order_id
					GROUP BY Orders.shippingDate";
		$link = mysqli_connect($conn, $login, $password, $dbname);
		$revenue = 0;
		$result = mysqli_query($link, $query);
		//if query is successful
		if ($result){
				
		}
				
			
	?>
    
</head>
<body>

</body>
</html>