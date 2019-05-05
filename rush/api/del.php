<?php
require_once "config/connect.php";

function    delGood($id)
{
    $connect = connect_shop();
    mysqli_query($connect, "DELETE FROM products WHERE id = '$id'");
    mysqli_close($connect);
}

function    delIdProdToCat($id)
{
    $connect = connect_shop();
    mysqli_query($connect, "DELETE FROM prod_to_cat WHERE id = '$id'");
    mysqli_close($connect);
}

function    delUser($id)
{
    $connect = connect_shop();
    mysqli_query($connect, "DELETE FROM users WHERE id = '$id'");
    mysqli_close($connect);
}

function    delCat($id)
{
    $connect = connect_shop();
    mysqli_query($connect, "DELETE FROM cat_list WHERE id = '$id'");
    mysqli_close($connect);
}

function    delTransactionElements($id)
{
    $connect = connect_shop();
    mysqli_query($connect, "DELETE FROM transaction_elements WHERE id = '$id'");
    mysqli_close($connect);
}