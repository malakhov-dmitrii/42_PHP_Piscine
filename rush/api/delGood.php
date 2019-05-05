<?php
    require_once "check.php";
    require_once "del.php";
    require_once "get.php";

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");

    function    delProdToCat($id)
    {
        $datas = getIdProdToCat($id);
        foreach ($datas as $data)
            delIdProdToCat($data['id']);
    }

    function    delTransactionsElementProd($id)
    {
        $datas = getTransactionElementProd($id);
        foreach ($datas as $data)
            delTransactionElements($data['id']);
    }

    function    delGoods()
    {
        if (array_key_exists("id", $_POST) 
            && (!is_numeric($_POST["id"])))
            $response["response"]["error"] = "Wrong parameter 'ID'";
        else if ($_POST
        && array_key_exists("token", $_POST)
        && array_key_exists("id", $_POST)
        && checkToken($_POST["token"])
        && checkAdmin($_POST["token"])
        )
        {
            $arr = checkArr($_POST);
            delTransactionsElementProd($arr["id"]);
            delProdToCat($arr["id"]);
            delGood($arr["id"]);
            $response["response"]["status"] = "ok";
        }
        else
            $response["response"]["error"] = "Error";
        exit(json_encode($response, JSON_PRETTY_PRINT));
    }
    delGoods();