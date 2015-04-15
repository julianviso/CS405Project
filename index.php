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
              <h3>Featured Products</h3>
            </div>

            <div class="page-no">
                <p>Result Pages:<ul>
                    <li><a href="#">1</a></li>
                    <li class="active"><a href="#">2</a></li>
                    <li class="active"><a href="#">3</a></li>
                    <li>[<a href="#"> Next>>></a >]</li>
                    </ul>
                </p>
            </div>
            <div class="clear"></div>
        </div>
     
     
        <div class="section group">
<?php     
        function showproduct($row){
            $name = $row["name"];
            $description = $row["description"];
            $price = $row["price"];
            echo '<div class="grid_1_of_4 images_1_of_4">
                    <form name="product_listing" method="post" action="product_details.php">
                    <img src="images/feature-pic1.png" alt="" />
                    <h1>'.$name.'</h1>
                    <p>'.$description.'</p>
                    <p><span class="strike">$'.$price.'</span><span class="price">$'.$price.'</span></p>

                    <div class="button"><span><img src="images/cart.jpg" alt="Add to cart" /><a href="preview-3.html" class="cart-button">Add to Cart</a></span> </div>
                        <input type="hidden" name="prod_id" value="2" />
                        <div class="button">
                            <span><input type="submit" value="Details" /></span>
                        </div>
                    </form>
                </div>
                ';
        }

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
        $page_num = 1;
        
        if (isset($_SERVER["REQUEST_METHOD"])
            && $_SERVER["REQUEST_METHOD"] == "POST"
            && isset($_POST["page_num"])){
                
            for($i=0; $i < 4; $i = $i +1){
                showproduct($row);
            }        
        }
        else{
            
            for($i=1; $i <= 4; $i = $i +1){
                $row = getProduct($link, $i);
                showproduct($row);
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


