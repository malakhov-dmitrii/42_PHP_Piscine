<?php
    require_once "check.php";
    require_once "set.php";
    require_once "get.php";

    // header('Content-Type: application/json');
    // header('Access-Control-Allow-Origin: *');
    // header('Access-Control-Allow-Methods: GET, POST');
    // header("Access-Control-Allow-Headers: X-Requested-With");

    function    checkFullProdId($prod)
    {
        $len = count($prod);
        $response["response"]["error"] = "Wrong parameter 'Product'";
        for ($i = 0; $i < $len; $i++)
        {
            if (!checkProdID($prod[$i]['id']))
                exit(json_encode($response, JSON_PRETTY_PRINT));
        }
    }

    function    addTransactionElement($prod_id, $idTransaction)
    {
        $len = count($prod_id);
        for ($i = 0; $i < $len; $i++)
            setTransactionElements($prod_id[$i], $idTransaction);
    }

    function    addTransactions()
    {
        if (array_key_exists("payment", $_POST) 
            && (!is_numeric($_POST["payment"])))
            $response["response"]["error"] = "Wrong parameter 'Payment'";
        else if ($_POST
        && array_key_exists("token", $_POST)
        && array_key_exists("prod", $_POST)
        && array_key_exists("payment", $_POST)
        && array_key_exists("commentary", $_POST)
        && checkToken($_POST["token"])
            )
        {
            $arr = checkArr($_POST);
            $prod = json_decode(str_replace("&quot;", "\"", $arr["prod"]), true);
            checkFullProdId($prod);
            $idTransaction = setTransaction($arr);
            addTransactionElement($prod, $idTransaction, $arr["quantity"]);
            $response["response"]["status"] = "Ok";
        }
        else
            $response["response"]["error"] = "Error";
        exit(json_encode($response, JSON_PRETTY_PRINT));
    }
    addTransactions();