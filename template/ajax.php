<?php
header('Content-Type: application/json');

require('../database/db-controller.php');
require('../database/product-controller.php');

$db = new DBController();
$product = new Product($db);

if (isset($_POST['itemid'])) {
    $result = $product->getProduct((int)$_POST['itemid']);
    echo json_encode($result);
}
