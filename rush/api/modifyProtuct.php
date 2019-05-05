<?php
    require_once "check.php";
    require_once "modify.php";

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");

    function    modifyProducts()
    {
        if ($_POST && array_key_exists("id", $_POST) 
            && (!is_numeric($_POST["id"])))
            $response["response"]["error"] = "Wrong parameter 'ID'";
        else if ($_POST && array_key_exists("quantity", $_POST) 
            && (!is_numeric($_POST["quantity"])))
            $response["response"]["error"] = "Wrong parameter 'Quantity'";
        else if ($_POST && array_key_exists("value", $_POST) 
            && (!is_numeric($_POST["value"])))
            $response["response"]["error"] = "Wrong parameter 'Value'";
        else if ($_POST
            && array_key_exists("id", $_POST)
            && array_key_exists("name", $_POST)
            && array_key_exists("quantity", $_POST)
            && array_key_exists("value", $_POST)
            && array_key_exists("description", $_POST)
            && array_key_exists("img", $_POST)
            && checkToken($_POST["token"])
            && checkAdmin($_POST["token"])
            )
        {
            $arr = checkArr($_POST);
            modifyProduct($arr);
            $response["response"]["status"] = "ok";
        }
        else
            $response["response"]["error"] = "Error";
        exit(json_encode($response, JSON_PRETTY_PRINT));
    }
    modifyProducts();