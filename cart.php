<?php
ob_start();
include("template/_header.php");
count($product->getData('cart')) ? include('template/_cart.php') :  include('template/not-found/_cart-not-found.php');
count($product->getData('wishlist')) ? include('template/_wishlist.php') :  include('template/not-found/_wishlist-not-found.php');
include("template/_new-phones.php");
include("template/_footer.php");
ob_end_flush();
