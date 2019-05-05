<?php
    require_once "update.php";
    require_once "check.php";

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
    
    function    setAdmin()
    {
        if (array_key_exists("status", $_POST) && (!is_numeric($_POST["status"]) || !($_POST["status"] == '1' || $_POST["status"] == '0')))
            $response["response"]["error"] = "Wrong parameter 'Status'";
        else if ($_POST
            && array_key_exists("token", $_POST)
            && array_key_exists("status", $_POST)
            && array_key_exists("login", $_POST)
            && checkToken($_POST["token"])
            && checkAdmin($_POST["token"]))
        {
            $arr = checkArr($_POST);
            updateAdmin($arr["token"], $arr["status"], $arr["login"]);
            $response["response"]["status"] = "ok";
        }
        else
            $response["response"]["error"] = "Error";
        exit(json_encode($response, JSON_PRETTY_PRINT));
    }
    setAdmin();