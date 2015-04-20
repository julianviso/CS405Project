<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->


<!DOCTYPE HTML>
<head>
<title>University of Kentucky CS405 Online Store | Home </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/menu.css" rel="stylesheet" type="text/css" media="all"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="js/script.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> 
<script type="text/javascript" src="js/nav.js"></script>
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<script type="text/javascript" src="js/nav-hover.js"></script>
<link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
<script type="text/javascript">
  $(document).ready(function($){
    $('#dc_mega-menu-orange').dcMegaMenu({rowItems:'4',speed:'fast',effect:'fade'});
  });
</script>
    

</head>

<body>

    <?php
        require "sql/serverinfo.php";
        include "components/header_top.php";
        include "components/header_menu.html";
    ?>
<!--
  <div class="wrap">

	<div class="header_bottom">
		<div class="header_bottom_left">
			<div class="section group">
				<div class="listview_1_of_2 images_1_of_2">
					<div class="listimg listimg_2_of_1">
						 <a href="preview.html"> <img src="images/pic4.png" alt="" /></a>
					</div>
				    <div class="text list_2_of_1">
						<h2>Iphone</h2>
						<p>Lorem ipsum dolor sit amet sed do eiusmod.</p>
						<div class="button"><span><a href="preview.html">Add to cart</a></span></div>
				   </div>
			   </div>			
				<div class="listview_1_of_2 images_1_of_2">
					<div class="listimg listimg_2_of_1">
						  <a href="preview-5.html"><img src="images/pic3.png" alt="" / ></a>
					</div>
					<div class="text list_2_of_1">
						  <h2>Sansung</h2>
						  <p>Lorem ipsum dolor sit amet, sed do eiusmod.</p>
						  <div class="button"><span><a href="preview-5.html">Add to cart</a></span></div>
					</div>
				</div>
			</div>
			<div class="section group">
				<div class="listview_1_of_2 images_1_of_2">
					<div class="listimg listimg_2_of_1">
						 <a href="preview-3.html"> <img src="images/pic3.jpg" alt="" /></a>
					</div>
				    <div class="text list_2_of_1">
						<h2>Acer</h2>
						<p>Lorem ipsum dolor sit amet, sed do eiusmod.</p>
						<div class="button"><span><a href="preview-3.html">Add to cart</a></span></div>
				   </div>
			   </div>			
				<div class="listview_1_of_2 images_1_of_2">
					<div class="listimg listimg_2_of_1">
						  <a href="preview-6.html"><img src="images/pic1.png" alt="" /></a>
					</div>
					<div class="text list_2_of_1">
						  <h2>Canon</h2>
						  <p>Lorem ipsum dolor sit amet, sed do eiusmod.</p>
						  <div class="button"><span><a href="preview-6.html">Add to cart</a></span></div>
					</div>
				</div>
			</div>
		  <div class="clear"></div>
		</div>
         <div class="header_bottom_right_images">
-->
        <!-- FlexSlider -->
        <!--
          <section class="slider">
              <div class="flexslider">
                <ul class="slides">
                    <li><img src="images/1.jpg" alt=""/></li>
                    <li><img src="images/2.jpg" alt=""/></li>
                    <li><img src="images/3.jpg" alt=""/></li>
                    <li><img src="images/4.jpg" alt=""/></li>
                </ul>
              </div>
           </section>
        -->
        <!-- FlexSlider -->
<!--
       </div>
	  <div class="clear"></div>
  </div>	
</div>
-->
 <div class="main">
    <div class="content">
        <div class="content_top">
            <div class="heading">
              <h3>Shopping Featured Products</h3>
            </div>
<?php
    /**
     *  The purpose of the following section is to determine the
     * total number of pages that need to be displayed, followed 
     * by a small form menu to change the products that are 
     * displayed.
     *
     * Preconditions:
     *  The user may or may not have sent a POST request.
     *  The number of possible pages to display may be required.
     *
     * Post-conditions:
     *  The $_SESSION["total_pages"] has the total pages
     * available for browsing.
     *  The current page is displayed.
     */

    //Get the total number of products
    if (!isset($_SESSION["total_pages"])){
        //Connect to the database
        $link = mysqli_connect($host, $login, $password, $dbname);
        
        //Determine the total number of products available
        $query_string = 
                "SELECT COUNT(*)
                FROM Products";
        $response = mysqli_query($link, $query_string);
        $row = mysqli_fetch_array($response);
        
        //Calculate the total pages available to display
        $total_pages = ceil((int)($row["COUNT(*)"])/4);
        echo '<h3>'.$total_products.'</h3>';
        if (mysqli_error($link)){
            echo $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
        }
        $_SESSION["total_pages"] = $total_products;
        mysqli_close($link);
    }

    //Displaying page choice numbers, and form for getting the next four products.
    echo    '<div class="page-no">
                <form name="page_update" method="post" action="index.php">
                <p>Result Pages:
                    <ul>';

    //If this is a POST request, display the requested page number
    if(isset($_SERVER["REQUEST_METHOD"])
        && $_SERVER["REQUEST_METHOD"] == "POST"
        && isset($_POST["page"])){

        $current = (int)$_POST["page"];
        if (isset($_POST["next"]) && $current < $total_pages - 1){
            $current = $current + 1;
        }
        else if (isset($_POST["prev"]) && $current > 0){
            $current = $current - 1;
        }
        $_POST["page"] = $current;

        // echo '<h3>'.$_POST["next"].'</h3>';
        // echo '<h3>'.$_POST["prev"].'</h3>';
        echo '<input type="hidden" name="page" value="'.$current.'"></input>';
        echo '<li><input type="submit" name="prev" value="Prev" /></li>';

        //Initializing start and stop conditions
        $i = $current - 3;
        if ($i < 1){
            $i = 1;   
        }
        $j = $current + 3;
        //Display page numbers in a list
        for (; $i < $j; $i = $i +1){
            if ($i == $current + 1){
                echo '<li>'.$i.'</li>';   
            }
            else {
            echo '<li class="active"><a href ="#">'.$i.'</a></li>';
            }
        }

    }
    //Otherwise, just display the first page options
    else {
        echo '<li><a href="#">1</a></li>
        <li class="active"><a href="#">2</a></li>
        <li class="active"><a href="#">3</a></li>';
        echo '<input type="hidden" name="page" value="0" />';

    }
    echo            '<li><input type="submit" name = "next" value="Next" /></li>';
    echo'           </ul>
                </p>
                </form>
            </div>
            <div class="clear"></div>';
        
?>
        </div>
        <div class="section group">
<?php   
        /**
         * getDiscount
         * Preconditions:
         *  A connection to the database
         *  A row from the Products database
         * Post-conditions:
         *  Displays a single product, with possible discounted price.
         *
         */
        function getDiscount($link, $row){
            $prod_id = $row["prod_id"];
            
            $query = "SELECT DISTINCT *
                      FROM Promotions
                      WHERE prod_id='$prod_id'";
            $response = mysqli_query($link, $query);
            //$num_rows = mysqli_num_rows($response);
            if (mysqli_error($link)){
                echo $err_message = mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
            }

            $discount = 0;
            // Find if there are any promotions. 
            // The last one overrides.
            while($row = mysqli_fetch_array($response)){
                $discount = (float)($row["discount"]);
            }
            
            return $discount;
        }

        /**
         * showproduct()
         * Purpose:
         *  Shows a single product from the given row.
         * Preconditions:
         *  $row is a mysql Products table row
         *  $row["name"], $row["price"], and $row[descriptions"]
         *  should be initialized.
         * Post-conditions:
         *  Displays a single product.
         *  Has an add to cart button and details button.
         */
        function showproduct($link, $row){
            $prod_id = $row["prod_id"];
            $name = $row["name"];
            $description = $row["description"];
            $price = $row["price"];
            $current_url = base64_encode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            $thumbnail_src = "Thumbnails/sorry.png";
            if(file_exists("Thumbnails/" .$name . ".png")){
                $thumbnail_src = "Thumbnails/" .$name . ".png";
            }
            
            echo '<div class="grid_1_of_4 images_1_of_4">
                    <form name="product_listing" method="post" action="product_details.php">
                    <img src="'.$thumbnail_src.'" alt="" />
                    <h1>'.$name.'</h1>
                    <p>'.$description.'</p>';
            
            //Check if there is a promotion for this item
            if( ($discount = getDiscount($link, $row)) > 0){
                echo '<p><span class="strike">$'.$price.'</span>';
                $discounted_price = $price - $discount * $price;
                if (true){
                    echo '<span class="price">$'.$discounted_price.'</span></p>';
                }
            }
            else {
                echo '<span class="price">$'.$price.'</span></p>';
            }

            echo '<div class="button"><span><img src="images/cart.jpg" alt="Add to cart" /><a href="cart_update.php?addProduct='.$row["prod_id"].'&prod_id='.$row["prod_id"].'&newName='.$row["name"].'&newPrice='.$row["price"].'&newQty=1&return_url='.$current_url.'" class="cart-button">Add to Cart</a></span> </div>
                        <input type="hidden" name="prod_id" value="'.$row["prod_id"].'" />
                        <div class="button">
                            <span><input type="submit" value="Details" /></span>
                        </div>
                    </form>
                </div>
                ';
        }

        /**
         * getProduct()
         * Purpose:
         *  Gets a single row from the products table..
         * Precondions:
         *  A connection to the mysql database
         * Post-conditions:
         *  Returns a row from the database corresponding to the
         *  product ID.
         */
        function getProduct($link, $prod_id){
            //Query for the Orders corresponding to this session user
            $query_string = 
                "SELECT *
                FROM Products
                WHERE prod_id = '$prod_id'";

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

        //Connect to the database
        $link = mysqli_connect($host, $login, $password, $dbname);
        $page = 1;
        
        if (isset($_SERVER["REQUEST_METHOD"])
            && $_SERVER["REQUEST_METHOD"] == "POST"
            && isset($_POST["page"])){
                
            $i = ((int)($_POST["page"])) * 4 + 1;
            $j = $i + 3;
            for(; $i <= $j; $i = $i +1){
                $row = getProduct($link, $i);
                showproduct($link, $row);
            }        
        }
        else{ //Just display the first page.
            for($i=1; $i <= 4; $i = $i +1){
                $row = getProduct($link, $i);
                showproduct($link, $row);
            }
        }
        mysqli_close($link);
        
?>     
            </div>
            <!--
			<div class="content_bottom">
    		<div class="heading">
    		<h3>New Products</h3>
    		</div>
    		<div class="sort">
    		<p>Sort by:
    			<select>
    				<option>Lowest Price</option>
    				<option>Highest Price</option>
    				<option>Lowest Price</option>
    				<option>Lowest Price</option>
    				<option>Lowest Price</option>
    				<option>In Stock</option>  				   				
    			</select>
    		</p>
    		</div>
    		<div class="show">
    		<p>Show:
    			<select>
    				<option>4</option>
    				<option>8</option>
    				<option>12</option>
    				<option>16</option>
    				<option>20</option>
    				<option>In Stock</option>  				   				
    			</select>
    		</p>
    		</div>
    		<div class="page-no">
    			<p>Result Pages:<ul>
    				<li><a href="#">1</a></li>
    				<li class="active"><a href="#">2</a></li>
    				<li><a href="#">3</a></li>
    				<li>[<a href="#"> Next>>></a >]</li>
    				</ul></p>
    		</div>
    		<div class="clear"></div>
    	</div>
            -->
            <!--
			<div class="section group">
				<div class="grid_1_of_4 images_1_of_4">
					 <a href="preview-3.html"><img src="images/new-pic1.jpg" alt="" /></a>
					 <div class="discount">
					 <span class="percentage">40%</span>
					</div>
					 <h2>Lorem Ipsum is simply </h2>
					 <p><span class="strike">$438.99</span><span class="price">$403.66</span></p>
				     <div class="button"><span><img src="images/cart.jpg" alt="" /><a href="preview-3.html" class="cart-button">Add to Cart</a></span> </div>
				     <div class="button"><span><a href="preview-3.html" class="details">Details</a></span></div>
				</div>
				<div class="grid_1_of_4 images_1_of_4">
					<a href="preview-4.html"><img src="images/new-pic2.jpg" alt="" /></a>
					 <div class="discount">
					 <span class="percentage">22%</span>
					</div>
					 <h2>Lorem Ipsum is simply </h2>
					 <p><span class="strike">$667.22</span><span class="price">$621.75</span></p>
				      <div class="button"><span><img src="images/cart.jpg" alt="" /><a href="preview-4.html" class="cart-button">Add to Cart</a></span></div>
				     <div class="button"><span><a href="preview-4.html" class="details">Details</a></span></div>
				</div>
				<div class="grid_1_of_4 images_1_of_4">
					<a href="preview-2.html"><img src="images/feature-pic2.jpg" alt="" /></a>
					<div class="discount">
					 <span class="percentage">55%</span>
					</div>
					 <h2>Lorem Ipsum is simply </h2>
					 <p><span class="strike">$457.22</span><span class="price">$428.02</span></p>
				      <div class="button"><span><img src="images/cart.jpg" alt="" /><a href="preview-2.html" class="cart-button">Add to Cart</a></span> </div>
				     <div class="button"><span><a href="preview-2.html" class="details">Details</a></span></div>
				</div>
				<div class="grid_1_of_4 images_1_of_4">
				 <img src="images/new-pic3.jpg" alt="" />
				  <div class="discount">
					 <span class="percentage">66%</span>
					</div>
					 <h2>Lorem Ipsum is simply </h2>					 
					 <p><span class="strike">$643.22</span><span class="price">$457.88</span></p>
				      <div class="button"><span><img src="images/cart.jpg" alt="" /><a href="#" class="cart-button">Add to Cart</a></span> </div>
				     <div class="button"><span><a href="#" class="details">Details</a></span></div>
				</div>
			</div> 
            -->
    </div>
 </div>


</body>

<?php
    include "components/footer.html";
?>


