<!--
update_inventory.php
Purpose:
    Same as view inventory, but with editable text boxes to change the quantity of any component.
-->
<!DOCTYPE HTML>

<head>
<title>View Inventory</title>
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
            //else if normal employee
            include "../components/staffHeader_menu.html"; 
        }
    ?>
</head>
<body>
    <?php
        /**
        * updateProduct()
        * Purpose:
        *   Actually changes the database's contents.
        * Preconditions:
        *   The following must exist:
        *   $_POST["prod_id"]
        *   $_POST["price"]
        *   $_POST["qty"]
        * Postconditions:
        *   Sent an sql update to the mysql server changing
        *   the price and quantity of a product.
        *   Return null if no errors, else returns an error message
        */            
        function updateProduct(){
            global $conn, $login, $password, $dbname;
            //Connect to the database.
            $err_message = null;
            $link = mysqli_connect($conn, $login, $password, $dbname);
            if (mysqli_error($link)){
                $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                return $err_message;
            }

            //Update the quantity
            $query = 'UPDATE Products
                      SET qty='.$_POST["qty"].'
                      WHERE prod_id='.$_POST["prod_id"];
            $result = mysqli_query($link, $query);
            if (mysqli_error($link)){
                    $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
            }

            $row_nums = mysqli_num_rows($result);
            if ($row_nums < 1){
                $err_message = 'Error: There is no product with ID number: '.$item["prod_id"].'<br/>';
            }

            //Update the price
            $query = 'UPDATE Products
                      SET price='.$_POST["price"].'
                      WHERE prod_id='.$_POST["prod_id"];
            $result = mysqli_query($link, $query);
            if (mysqli_error($link)){
                    $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
            }
            $row_nums = mysqli_num_rows($result);
            if ($row_nums < 1){
                $err_message = 'Error: There is no product with ID number: '.$item["prod_id"].'<br/>';
            }

            mysqli_close($link);
            return $err_message;
        }

        /**
        * addProduct()
        * Purpose:
        *   Inserts a new row into the Products table.
        * Preconditions:
        *   The following must exist:
        *   $_POST["prod_id"]
        *   $_POST["price"]
        *   $_POST["qty"]
        * Postconditions:
        *   Sent an sql update to the mysql server adding a row to
        *   the Products table.
        *   Return null if no errors, else returns an error message
        */
        function addProduct(){
            global $conn, $login, $password, $dbname;
            //Connect to the database.
            $err_message = null;
            $link = mysqli_connect($conn, $login, $password, $dbname);
            if (mysqli_error($link)){
                $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
                return $err_message;
            }
            $name = $_POST["name"];
            $price = $_POST["price"];
            $qty = $_POST["qty"];
            //Update the quantity
            $query = "INSERT INTO Products VALUES
                      (DEFAULT, '$name', '$price', '$qty')";
            $result = mysqli_query($link, $query);
            if (mysqli_error($link)){
                $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
            }
            
            $result = mysqli_query($link, "
                        SELECT AUTO_INCREMENT 
                        FROM information_schema.tables
                        WHERE table_name = 'Products' 
                        AND table_schema = DATABASE()
                    ");
            $data = mysqli_fetch_array($result);
            //Now give thisOrder_id the next num
            $thisOrder_id = $data["AUTO_INCREMENT"];
            
            return $thisOrder_id - 1;
            
        }

        /**
        * validatePost()
        * Purpose:
        *   Makes sure that all fields are filled out.
        * Preconditions:
        *   The following must exist:
        *   $_POST["prod_id"]
        *   $_POST["price"]
        *   $_POST["qty"]
        * Postconditions:
        *   Determines if the inputs are not empty, and if so,
        *   calls the update function.
        */
        function validatePost(){
            if ($_POST["name"] == ""
                || $_POST["price"] == ""
                || $_POST["qty"] == "") {
                echo '<font color="red">PRICE AND QTY MUST BE FILLED OUT!</font>';   
            }
            else if (isset($_POST["add_product"])){
                $result = addProduct();
                if ($result != null){
                    echo '<font color="green">ADDED PRODUCT #' . $result .'</font>';   
                }
            }
            else {
                $result = updateProduct();
                if ($result != null){
                    echo '<font color="green">UPDATED PRODUCT ID #' . $_POST["prod_id"] .'</font>';   
                }
            }
        }

        //Check if this is a post request, and if so validates.
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            if (isset($_POST["prod_id"])
                && isset($_POST["name"])
                && isset($_POST["price"])
                && isset($_POST["qty"])){
                
                   validatePost();
            }
        }


        $link = mysqli_connect($host, $login, $password, $dbname);
        $query_string = "SELECT * FROM Products";
        $response = mysqli_query($link, $query_string);
        $num_rows = mysqli_num_rows($response);
        if ($num_rows == 0){
            echo "<h3>Inventory currently empty.</h3>";
            exit(0);
        }

        echo "<h3>Inventory</h3>";

        //Table header
        echo '
            <div class="orderlines">
            
            <table class="bordered">
            <tr>
                <th align="left">PRODUCT ID</td>
                <th align="left">NAME</td>
                <th align="left">PRICE</td>
                <th align="left">QTY</td>
                <th></th>
            </tr>';
        while($row = mysqli_fetch_array($response)){
            echo '
                <form name="update_inv" method="post" action="update_inventory.php">
                
                <tr>
                    <td><input name="prod_id" type="hidden" value="'.$row['prod_id'].'"</input>'.$row['prod_id'].'</td>
                    <td><input name="name" type="hidden" value="'.$row['name'].'"</input>'.$row['name'].'</td>
                    <td><input name="price" type="text" value="'.$row['price'].'"</input></td>
                    <td><input name="qty" type="text" value="'.$row['qty'].'"</input></td>
                    <td><input type="submit" name="Update" value="Update"></input></td>
                </tr>
                
                </form>
            ';
        }
        echo '
            <form name="add_product" method="post" action="update_inventory.php">
                
                <tr>
                    <td><input name="prod_id" type="hidden" value="'.$row['prod_id'].'"</input></td>
                    <td><input name="name" type="text"></input></td>
                    <td><input name="price" type="text" value="'.$row['price'].'"</input></td>
                    <td><input name="qty" type="text" value="'.$row['qty'].'"</input></td>
                    <td><input type="submit" name="add_product" value="Add Product"></input></td>
                </tr>
                
            </form>
            ';
        echo '</table><br/>
            <input type="submit" name="submit"></input>
            </div>';
            

    ?>
</body>