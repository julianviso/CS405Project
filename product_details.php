<!DOCTYPE HTML>
<head>
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="css/menu.css" rel="stylesheet" type="text/css" media="all"/>

</head>

<body>

    <?php
        include "components/header_top.php";
        include "components/header_menu.html";
    ?>
    
<div class="main">
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
                <div class="desc span_3_of_2">
                <h2>Lorem Ipsum is simply dummy text </h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>					
                <div class="price">
                    <p>Price: <span>$500</span></p>
                </div>
                <div class="available">
                    <p>Number Available:</p>

                </div>

            <div class="add-cart">
                <div class="button"><span><a href="#">Add to Cart</a></span></div>
                <div class="clear"></div>
            </div>
        </div>
			<div class="product-desc">
			<h2>Product Details</h2>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
	        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
	    </div>
			
	</div>

    <?php
        include "components/sidebar.html";
    ?>
            
 		</div>
 	</div>
</div>

<?php
    include "components/footer.html";     
?>
</body>