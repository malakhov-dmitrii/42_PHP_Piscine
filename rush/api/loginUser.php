<?php

require_once "update.php";
require_once "check.php";
require_once "tools.php";
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

function    loginUser()
{
    if ($_POST && array_key_exists("login", $_POST) && array_key_exists("passwd", $_POST) && checkUser($_POST["login"], $_POST["passwd"]))
    {
        $arr = checkArr($_POST);
        $guid = updateToken($arr["login"], $arr["passwd"]);
        $response["response"]["token"] = $guid;
        $response["response"]["admin"] = checkAdmin($guid);
    }
    else
        $response["response"]["error"] = "Error";
    exit(json_encode($response, JSON_PRETTY_PRINT));
}

loginUser();