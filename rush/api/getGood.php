<?php

require_once "get.php";
require_once "check.php";

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

function    infoGood()
{
    $arr = checkArr($_GET);
    if (array_key_exists("id", $_GET)
        && (!is_numeric($_GET["id"])))
        $response["response"]["error"] = "Wrong parameter 'ID'";
    else
    {
        $response["response"]["products"] = get_store('products', $_GET["id"]);
        if (!$response["response"]["products"])
        {
            $response["response"] = NULL;
            $response["response"]["error"] = "Product not found";
        }
        else
            $response["response"]["status"] = "ok";
    }
    exit (json_encode($response, JSON_PRETTY_PRINT));
}
infoGood();
