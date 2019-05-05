<?php
    require_once "check.php";
    require_once "set.php";

    // header('Content-Type: application/json');
    // header('Access-Control-Allow-Origin: *');
    // header('Access-Control-Allow-Methods: GET, POST');
    // header("Access-Control-Allow-Headers: X-Requested-With");

    function    addCat()
    {
        if ($_POST
            && array_key_exists("token", $_POST)
            && array_key_exists("name", $_POST)
            && array_key_exists("description", $_POST)
            && array_key_exists("img", $_POST)
            && checkToken($_POST["token"])
            && checkAdmin($_POST["token"]))
        {print "test";
            $arr = checkArr($_POST);
            setCat($arr);
            $response["response"]["status"] = "ok";
        }
        else
            $response["response"]["error"] = "Error";
        exit(json_encode($response, JSON_PRETTY_PRINT));
    }
    addCat();