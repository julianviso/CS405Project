<!DOCTYPE HTML>

    <?php
        require "sql/serverinfo.php";
        include "components/header_top.php";
        include "components/header_menu.html";

        if (!isset($_SESSION["email"])) {
            //header("location: PleaseLogin.php");
            //exit();
        }

    ?>

<head>
    <title> Product Details </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="css/menu.css" rel="stylesheet" type="text/css" media="all"/>

</head>

<body>

    <?php    
    
$div_top_string = '<div class="main">
    <div class="content">
    	<div class="content_top">
    		<div class="back-links">
    		<p><a href="#">Home</a> >> <a href="#">Electronics</a></p>
    	    </div>
    		<div class="clear"></div>
    	</div>
    	<div class="section group">
            <div class="cont-desc span_1_of_2">				
                <div class="grid images_3_of_2">
                    <img src="images/preview-img.jpg" alt="" />
                </div>
                <div class="desc span_3_of_2">';
$title_string =  '<h2>Lorem Ipsum is simply dummy text </h2>';
$lorem_string1 = '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>';					
$price_string = '<div class="price">
                    <p>Price: <span>$500</span></p>
                </div>';
$available_string = '<div class="available">
                    <p>Number Available:</p>
                </div>';

$add_cart_string = '<div class="add-cart">
                <div class="button"><span><a href="#">Add to Cart</a></span></div>
                <div class="clear"></div>
            </div>
        </div>';
$product_details_top_string= '<div class="product-desc">
        <h2>Product Details</h2>';
$lorem_string2 = "<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>";

$closing_string =	    '</div>
			
	</div>
     		</div>
 	</div>
</div>';

function displayInfo($row){
    global  $div_top_string, $lorem_string1, $price_string,
            $available_string, $add_cart_string,
            $product_details_top_string, $lorem_string2,
            $closing_string;
    $current_url = base64_encode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    
    //$row = array();
    //$row["prod_id"] = 5;
    //$row["name"] = "iPhone";
    //$row["price"] = 100.0;
    //$row["qty"] = 1;
    //$row["description"] = "5th generation.";
    
    echo $div_top_string;
    //echo $lorem_string1;
    echo '<h1>'.$row["name"].'</h1>';
    //echo $price_string;
    echo '<div class="price">
            <p>Price: <span>'.$row["price"].'</span></p>
         </div>';
    //echo $available_string;
    echo '<div class="available">
            <p>Number Available:</p>'.$row["qty"].'</div>';
    //echo $add_cart_string;
    echo '<div class="add-cart">
                <div class="button"><span>
                <a href="cart_update.php?addProduct='.$row["prod_id"].'&prod_id='.$row["prod_id"].'&newName='.$row["name"].'&newPrice='.$row["price"].'&newQty='.$row["qty"].'&return_url='.$current_url.'">Add to Cart</a></span></div>
                <div class="clear"></div>
            </div>
        </div>';
    echo $product_details_top_string;
    echo '<p>'.$row["description"].'</p>';
    echo $closing_string;
}

function displayDummy($row){
    global $div_top_string, $lorem_string1, $price_string, $available_string, $add_cart_string, $product_details_top_string, $lorem_string2, $closing_string;
    echo $div_top_string;
    echo $lorem_string1;
    echo $price_string;
    echo $available_string;
    echo $add_cart_string;
    echo $product_details_top_string;
    echo $lorem_string2;
    echo $closing_string;  
}

function getProduct($link){
    //Query for the Orders corresponding to this session user
    $query_string = 
        "SELECT *
        FROM Products
        WHERE prod_id = '".$_POST["prod_id"]."'";

    //Get the query response
    $response = mysqli_query($link, $query_string);
    $num_rows = mysqli_num_rows($response);
    if (mysqli_error($link)){
            echo $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
    }

    //The array of the product row
    $row = mysqli_fetch_array($response);

    return $row;
}

    ?>
    <?php
        //Connect to the database
        $link = mysqli_connect($host, $login, $password, $dbname);




        
        if ($_SERVER["REQUEST_METHOD"] == "POST" 
            && isset($_POST["prod_id"])){
            
            $row = getProduct($link);
            displayInfo($row);
        }
        else{
            $row = array();
            displayDummy($row);   
        }

        mysqli_close($link);
    ?>
            


<?php
    include "components/footer.html";     
?>
</body>