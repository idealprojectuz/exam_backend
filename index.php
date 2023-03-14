<?php

include('products.php');
include('config.php');
// include('lib/getdata.php');
$header = getallheaders();
$message = [];
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
$products = new Products;

if (isset($header['API_KEY']) && $header['API_KEY'] == API_KEY) {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $products->getproduct();
    } else if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
        $products->newproduct($_POST, $_FILES);
    }
} else {
    $message['status'] = 400;
    $message['message'] = 'not authentification';
    echo json_encode($message, JSON_PRETTY_PRINT);
}
// echo '<pre>';
// var_dump($_SERVER);
// echo '</pre>';
