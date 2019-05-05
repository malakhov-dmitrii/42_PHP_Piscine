<?php

require_once "config/connect.php";

function    updateToken($login)
{
    $guid = createGuid();
    $connect = connect_shop();
    mysqli_query($connect, "UPDATE `users` SET `token` = '$guid' WHERE `user_login` = '$login'");
    mysqli_close($connect);
    return $guid;
}

function    updateQuantity($quantity, $id)
{
    $connect = connect_shop();
    mysqli_query($connect, "UPDATE `products` SET `quantity` = '$quantity' WHERE `id` = '$id'");
    mysqli_close($connect);
    return $guid;
}

function    updateAdmin($token, $status, $login)
{
    $connect = connect_shop();
    mysqli_query($connect, "UPDATE `users` SET `is_admin` = '$status' WHERE `user_login` = '$login'");
    mysqli_close($connect);
}