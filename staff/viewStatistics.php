<!DOCTYPE HTML>
<head>
<title><?php echo $_GET['interval']?> Date</title>
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
    <form name="stats" method="post" action="viewStatistics.php">
	    <input type="submit" value="Last Week" name="week" />
        <input type="submit" value="Last Month" name="month"/>
        <input type="submit" value="Last Year" name="year"/>
    </form>
	<?php
		require "../sql/serverinfo.php";
		//Get orders of items and check that order date is in range (now to chosen interval)
		//NOW() = return current date and time
		//DAY() = synonym for DAYOFMONTH(date) which returns the day of the month for date

        if(isset($_SERVER["REQUEST_METHOD"]) &&
            $_SERVER["REQUEST_METHOD"] == "POST"){
                        		
            $link = mysqli_connect($conn, $login, $password, $dbname);

            showStats($link);
            mysqli_close($link);
        }

        // Gets the date from a week ago, month ago, or year ago
        function getDesiredDate(){
            $query = "";
            $date = strtotime("now");
            if(isset($_POST["week"])){
                $date = strtotime("-1 week");
                $date = date( 'Y-m-d', $date );
            }
            else if (isset($_POST["month"])){
                $date = strtotime("-1 month");
                $date = date( 'Y-m-d', $date );
            }
            else if (isset($_POST["year"])){
                $date = strtotime("-1 year");
                $date = date( 'Y-m-d', $date );
            }
            else {
                echo "ERROR: DID NOT UNDERSTAND POST REQUEST";
                exit();
            }    
            return $date;
        }


        /**
        * processResult
        * Purpose:
        *   Gets all the data needed for the table.
        * Preconditions:
        *   $link - connection to the mysql database
        *   $result = response from the query 
                    SELECT *
                    FROM Orders
                    WHERE status=1 
                    AND orderDate > '$date'";
        * Post-conditions:
        *   An associative array of product IDs to quantities sold
        */
        function processResult($link, $result){
            $data = array();
            // Get every row from the Orderlines table
            while ($row = mysqli_fetch_array($result)){
                $oid = $row["order_id"];
                $lines_query = "SELECT *
                                FROM Orderlines
                                WHERE order_id= '$oid'";
                $lines_result = mysqli_query($link, $lines_query);
                if (mysqli_error($link)){
                    $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                }
                // Get each orderline belonging to this Order
                while ($line_row = mysqli_fetch_array ($lines_result)) {
                    $pid = (string)$line_row["prod_id"];
                    $qty = (string)$line_row["quantity"];
                    if(!isset($data[$pid])){
                        $data[$pid] = $line_row["quantity"];    
                    }
                    else{
                        $data[$pid] += $line_row["quantity"];
                    }
                }
            }
            
            return $data;
            
        }
        
        /**
        *   showRows()
        *   Purpose:
        *     Displays each product's quantity sold and total.
        *   Preconditions:
        *     $link = A connection to the mysql database
        *     $data = An associative array of product IDs to qty sold
        */
        function showRows($link, $data){
            
            $total = 0;
            foreach ($data as $key => $value){
                // Get the price of this item
                $query = "SELECT price
                          FROM Products
                          WHERE prod_id='$key'";
                $result = mysqli_query($link, $query);
                if (mysqli_error($link)){
                    $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                }
                $row = mysqli_fetch_array($result);
                $price = (float)($row["price"]);
                
                // Show results in the table
                echo "<tr><td>".$key."</td>";
                echo "<td>$price</td>";
                echo "<td>$value</td>";
                
                // Finally, calculate each subtotal, add to total
                $subtotal = $price * $value;
                echo "<td>$subtotal</td>";
                $total += $subtotal;
            }
            
            return $total;
        }


        /**
        * showStats()
        * Purpose:
        *   The main driver function.
        *   1. Gets the desired date with getDesiredDate()
        *   2. Queries for all Order rows in that range
        *   3. Begins drawing the table
        *   4. Processes results with processResults
        *   5. Shows all the rows with showRows
        *   6  Shows the total
        * Preconditions:
        *   A link to the mysql database
        * Post-conditions:
        *   A table with the price, qty, subtotals and total sold.
        *
        */
        function showStats($link) {
            $date = getDesiredDate();
            
            // First, find all the orders made after that time
            $query = "SELECT *
                  FROM Orders
                  WHERE status=1 
                  AND orderDate > '$date'";
            
            $result = mysqli_query($link, $query);
            if (mysqli_error($link)){
                $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
            }
            
            $result = mysqli_query($link, $query);
            if ($result){
                // Using the same css as the orderlines table in 
                // the view orders page.
                echo '<div class="orderlines">
                        <table class="bordered">
                        
                        <tr><th>prod_id</th>
                        <th>price</th>
                        <th>qty</th>
                        <th>total</th></tr>';
                
                // Get each order from the results
                $data = processResult($link, $result);
                
                // Calculate the total sold
                $total = showRows($link, $data);

                echo '<tr><th colspan="3">Total:</th><th>'.$total.'</th></tr></table>
                    </div>';            
            }
            else{
                echo $err_message;	
            }        
        }




           
	?>
</body>
</html>