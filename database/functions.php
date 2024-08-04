<?php

require('db-controller.php');

require('product-controller.php');
require('cart-controller.php');


$db = new DBController();

$product = new Product($db);
$product_shuffle = $product->getData();

$cart = new Cart($db);
