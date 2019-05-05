<?php
    function	createGuid()
    {
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45); // ASCII char "-"
        $uuid = chr(123) // ASCII char "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// ASCII char "}"
        return $uuid;
    }
    
    function    getPage($arr)
    {
        $page = 0;
        if (array_key_exists("page", $arr))
            $page = $arr["page"];
        return ($page);
    }