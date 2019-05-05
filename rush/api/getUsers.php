<?php
    require_once "check.php";
    require_once "del.php";
    require_once "get.php";
    require_once "tools.php";

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");

    function    delPrivate($datas)
    {
        $arr = array ();
        $arrs = array ();
        foreach ($datas as $data)
        {
            $arr["id"] = $data["id"];
            $arr["name"] = $data["user_name"];
            $arr["lastname"] = $data["user_lastname"];
            $arr["login"] = $data["user_login"];
            $arr["email"] = $data["email"];
            $arr["address"] = $data["user_address"];
            $arr["admin"] = $data["is_admin"];
            $arrs[] = $arr;
        }
        return $arrs;
    }

    function    infoUsers()
    {
        if (array_key_exists("token", $_POST)
        && checkToken($_POST["token"])
        && checkAdmin($_POST["token"])
        )
        {
            $arr = checkArr($_POST);
            $page = getPage($arr);
            $response["response"]["products"] = delPrivate(gets_store('users', $page));
            $response["response"]["status"] = "ok";
            exit (json_encode($response, JSON_PRETTY_PRINT));
        }
        else
            $response["response"]["error"] = "Error";
        exit(json_encode($response, JSON_PRETTY_PRINT));
    }
    infoUsers();