<?php

include('products.php');
include('config.php');
// include('lib/getdata.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json; charset=utf-8');
$headers = getallheaders();
$message = [];

$products = new Products;
if (isset($headers['Authorization']) && $headers['Authorization'] == API_KEY) 
{
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


?>