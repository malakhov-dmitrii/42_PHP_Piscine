<?php

require_once "get.php";
require_once "check.php";
require_once "tools.php";

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

function    getTransactionsElements($datas)
{
    $ar = array ();
    $arr = array ();
    $arrs = array ();
    foreach ($datas as $data)
    {
        $arr = getTransactionsElement($data['id']);
        foreach ($arr as $a)
            $ar[] = $a;
        $data["basket"][] = $ar;
        $arrs[] = $data;
        $ar = NULL;
    }
    return ($arrs);
}

function    getTransactions()
{
    if (array_key_exists("token", $_POST)
    && checkToken($_POST["token"]))
    {
        $arr = checkArr($_POST);
        $page = getPage($arr);
        $response["response"]["products"] = getTransactionsElements(getTransaction($arr['token']));
        $response["response"]["status"] = "ok";
        exit (json_encode($response, JSON_PRETTY_PRINT));
    }
    else
        $response["response"]["error"] = "Error";
    exit(json_encode($response, JSON_PRETTY_PRINT));
}

getTransactions();
