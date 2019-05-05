<?php
    require_once "check.php";
    require_once "set.php";
    require_once "get.php";
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");

    function    checkFullCat($cat)
    {
        $len = count($cat);
        $response["response"]["error"] = "Wrong parameter 'Cat'";
        for ($i = 0; $i < $len; $i++)
        {
            if (!checkCat($cat[$i]))
                exit(json_encode($response, JSON_PRETTY_PRINT));
        }
    }

    function    addProdToCat($cat, $idGoods)
    {
        $response["response"]["error"] = "Error";
        $len = count($cat);
        for ($i = 0; $i < $len; $i++)
        {
            $idCat = getIdCat($cat[$i]);
            if ($idGoods < 0 || $idCat < 0)
                exit(json_encode($response, JSON_PRETTY_PRINT));            
            setProdToCat($idCat, $idGoods);
        }
    }

    function    addGood()
    {
        if (array_key_exists("quantity", $_POST) 
            && (!is_numeric($_POST["quantity"])))
            $response["response"]["error"] = "Wrong parameter 'Quantity'";
        else if (array_key_exists("value", $_POST) 
            && (!is_numeric($_POST["value"])))
            $response["response"]["error"] = "Wrong parameter 'Value'";
        else if ($_POST
            && array_key_exists("token", $_POST)
            && array_key_exists("name", $_POST)
            && array_key_exists("quantity", $_POST)
            && array_key_exists("value", $_POST)
            && array_key_exists("description", $_POST)
            && array_key_exists("img", $_POST)
            && array_key_exists("cat", $_POST)
            && checkToken($_POST["token"])
            && checkAdmin($_POST["token"])
            )
        {
            $arr = checkArr($_POST);
            $cat = json_decode(str_replace("&quot;", "\"", $arr["cat"]));
            checkFullCat($cat);
            $idGoods = setGoods($arr);
            addProdToCat($cat, $idGoods);
            $response["response"]["status"] = "Ok";
        }
        else
            $response["response"]["error"] = "Error";
        exit(json_encode($response, JSON_PRETTY_PRINT));
    }
    addGood();