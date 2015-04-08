<!--
header_top.html

Purpose:
    This is the very top of every page.  Contains the logo, shopping cart, and login button.
-->
<!DOCTYPE HTML>
<div class="header_top">
    <div class="logo">
        <a href="index.php"><img src="images/UK-logo.jpg" alt="" /></a>
    </div>
    <div class="header_top_right">
        <div class="search_box">
            <form>
                <input type="text" value="Search for Products" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search for Products';}"><input type="submit" value="SEARCH">
            </form>
        </div>
        <div class="shopping_cart">
            <div class="cart">
                <a href="Purchase.php" title="View my shopping cart">
                <a href="Purchase.php" title="View my shopping cart">
                    <strong class="opencart"> </strong>
                        <span class="cart_title">Cart</span>
                        <span class="no_product">
<?php
    session_start();
    if(isset($_SESSION["cart_items"])){
        $q = 0;
        foreach($_SESSION["cart_items"] as $item){
            $q += $item["qty"];
        }
        echo '<b>'.$q.'</b>: Items';
    }
    else{
        echo '(empty)';   
    }
?>
                        </span>
                </a>
            </div>
        </div>
        <div class="login">
          <span><a href="login.html"><img src="images/login.png" alt="" title="login"/></a></span>
        </div>
        <div class="clear"></div>
   </div>
   <div class="clear"></div>
</div>