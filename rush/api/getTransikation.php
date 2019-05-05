<?php

require_once "get.php";
require_once "check.php";
require_once "tools.php";

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");


function    getTransactionElements()
{
    if ($_POST && array_key_exists("id", $_POST) 
        && (!is_numeric($_POST["id"])))
        $response["response"]["error"] = "Wrong parameter 'ID'";
    else if (array_key_exists("token", $_POST)
    && checkToken($_POST["token"]))
    {
        $response["response"]["products"] = getTransactionElementProd($arr['id']);
        $response["response"]["status"] = "ok";
        exit (json_encode($response, JSON_PRETTY_PRINT));
    }
    else
        $response["response"]["error"] = "Error";
    exit(json_encode($response, JSON_PRETTY_PRINT));
}

getTransactionElements();
