<?php

    require_once "config/connect.php";

	function	checkString($str)
	{
		$str = strip_tags($str);
		$str = htmlspecialchars($str);
		return $str;
    }

    function    checkArr($arr)
    {
        foreach($arr as $key=>$value)
            $arr[$key] = checkString($arr[$key]);
        return ($arr);
    }

    function    checkUser($login, $pass)
    {
        $connect = connect_shop();
        $query = mysqli_query($connect, "SELECT * FROM `users` WHERE `user_login` = '$login'");
        $Row = mysqli_fetch_assoc($query);
        if ($pass === $Row['user_passwd'])
        {
            mysqli_close($connect);
            return (1);
        }
        mysqli_close($connect);
        return (0);
    }

    function    checkToken($token)
    {
        $connect = connect_shop();
        $query = mysqli_query($connect, "SELECT * FROM `users` WHERE `token` = '$token'");
        $Row = mysqli_fetch_assoc($query);
        mysqli_close($connect);
        if ($token === $Row['token'])
            return (1);
        return (0);
    }

    function    checkAdmin($token)
    {
        $connect = connect_shop();
        $query = mysqli_query($connect, "SELECT * FROM `users` WHERE `token` = '$token'");
        $Row = mysqli_fetch_assoc($query);
        if (1 == $Row['is_admin'])
        {
            mysqli_close($connect);
            return (1);
        }
        mysqli_close($connect);
        return (0);
    }

    function    checkReg($login, $email)
    {
        $connect = connect_shop();
        $query = mysqli_query($connect, "SELECT * FROM `users` WHERE `user_login` = '$login'");
        $Row = mysqli_fetch_assoc($query);
        if ($login === $Row['user_login'])
            return (1);
        $query = mysqli_query($connect, "SELECT * FROM `users` WHERE `email` = '$email'");
        $Row = mysqli_fetch_assoc($query);
        if ($email === $Row['email'])
            return (2);
        mysqli_close($connect);
        return (0);
    }

    function    checkCat($cat)
    {
        $connect = connect_shop();
        $query = mysqli_query($connect, "SELECT * FROM `cat_list` WHERE `category_name` = '$cat'");
        $Row = mysqli_fetch_assoc($query);
        if ($cat == $Row['category_name'])
        {
            mysqli_close($connect);
            return (1);
        }
        mysqli_close($connect);
        return (0);
    }

    function    checkProdID($id)
    {
        $connect = connect_shop();
        $query = mysqli_query($connect, "SELECT * FROM `products` WHERE `id` = '$id'");
        $Row = mysqli_fetch_assoc($query);
        mysqli_close($connect);
        if ($Row)
            return (1);
        return (0);
    }
    