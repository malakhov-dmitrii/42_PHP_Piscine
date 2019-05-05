<?php
    require_once "check.php";
    require_once "modify.php";

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");

    function    modifyUsers()
    {
        if ($_POST && array_key_exists("id", $_POST) 
            && (!is_numeric($_POST["id"])))
            $response["response"]["error"] = "Wrong parameter 'ID'";
        else if ($_POST && array_key_exists("admin", $_POST) 
            && (!is_numeric($_POST["admin"])))
            $response["response"]["error"] = "Wrong parameter 'Admin'";
        else if ($_POST
            && array_key_exists("id", $_POST)
            && array_key_exists("name", $_POST)
            && array_key_exists("lastname", $_POST)
            && array_key_exists("login", $_POST)
            && array_key_exists("email", $_POST)
            && array_key_exists("address", $_POST)
            && array_key_exists("passwd", $_POST)
            && array_key_exists("admin", $_POST)
            && checkToken($_POST["token"])
            && checkAdmin($_POST["token"])
            )
        {
            $arr = checkArr($_POST);
            modifyUser($arr);
            $response["response"]["status"] = "ok";
        }
        else
            $response["response"]["error"] = "Error";
        exit(json_encode($response, JSON_PRETTY_PRINT));
    }
    modifyUsers();