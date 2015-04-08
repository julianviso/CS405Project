<!DOCTYPE HTML>
<?php
    session_start();
    $_SESSION["cart_items"] = array();

    //Test values
    $cart_item["price"] = 200;
    $cart_item["name"] = "XBOX";
    $cart_item["prod_id"] = 1;
    $cart_item["qty"] = 2;
    $_SESSION["cart_items"][1] = $cart_item;

    $cart_item2["price"] = 250;
    $cart_item2["name"] = "3DS";
    $cart_item2["prod_id"] = 2;
    $cart_item2["qty"] = 1;
    $_SESSION["cart_items"][2] = $cart_item2;
?>