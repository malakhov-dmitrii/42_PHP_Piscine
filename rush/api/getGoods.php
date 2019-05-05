<?php

require_once "get.php";
require_once "check.php";
require_once "tools.php";

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

function    infoGoods()
{
    $arr = checkArr($_GET);
    $page = getPage($arr);
    $response["response"]["products"] = array_reverse(gets_store('products', $page));
    $response["response"]["status"] = "ok";
    exit (json_encode($response, JSON_PRETTY_PRINT));
}

infoGoods();
