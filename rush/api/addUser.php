<?php
require_once "get.php";
require_once "set.php";
require_once "check.php";
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

function regUser()
{
    if (!$_POST
        && !array_key_exists("name", $_POST)
        && !array_key_exists("lastname", $_POST)
        && !array_key_exists("login", $_POST)
        && !array_key_exists("email", $_POST)
        && !array_key_exists("address", $_POST)
        && !array_key_exists("passwd", $_POST))
        exit(json_encode($response, JSON_PRETTY_PRINT));
    else if (($error = checkReg($_POST["login"], $_POST["email"])))
    {
        if ($error == 1)
            $response["response"]["error"] = "Login exists";
        if ($error == 2)
            $response["response"]["error"] = "Email exists";
        exit(json_encode($response, JSON_PRETTY_PRINT));
    }
    setReg(checkArr($_POST));
    $response["response"]["status"] = "ok";
    exit(json_encode($response, JSON_PRETTY_PRINT));
}

regUser();