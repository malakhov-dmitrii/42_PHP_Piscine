<?php
error_reporting(0);
require_once "config/connect.php";

function    gets_store($table, $page)
{
    $shif = $page * 10;
    $page = $page * 10 + 10;
    $connect = connect_shop();
    $query = mysqli_query($connect, "SELECT * FROM $table"); // LIMIT $shif, $page");
    $data = array();
    while ($row = mysqli_fetch_assoc($query))
    {
        $categories = getIdProdToCat($row['id']);
        foreach ($categories as $category)
            $row['categories'][] = $category['category_id'];
        $data[] = $row;
    }
    mysqli_close($connect);
    return ($data);
}

function    get_store($table, $id)
{
    $shif = 0;
    $page *= 10;
    $connect = connect_shop();
    $query = mysqli_query($connect, "SELECT * FROM $table WHERE `id` = '$id'");
    $row = mysqli_fetch_assoc($query);
    mysqli_close($connect);
    return ($row);
}

function    get_id_user_token($token)
{
    $shif = 0;
    $page *= 10;
    $connect = connect_shop();
    $query = mysqli_query($connect, "SELECT * FROM users WHERE `token` = '$token'");
    $row = mysqli_fetch_assoc($query);
    mysqli_close($connect);
    return ($row['id']);
}

function    getIdCat($cat)
{
    $connect = connect_shop();
    $query = mysqli_query($connect, "SELECT * FROM `cat_list` WHERE `category_name` = '$cat'");
    $Row = mysqli_fetch_assoc($query);
    if ($cat == $Row['category_name'])
    {
        $id = $Row['id'];
        mysqli_close($connect);
        return ($id);
    }
    mysqli_close($connect);
    return (-1);
}

function    getIdProdToCat($id)
{
    $connect = connect_shop();
    $query = mysqli_query($connect, "SELECT * FROM `prod_to_cat` WHERE `product_id` = '$id'");
    $data = array ();
    while ($Row = mysqli_fetch_assoc($query))
        $data[] = $Row;
    return ($data);
}

function    getIdCatToProd($id)
{
    $connect = connect_shop();
    $query = mysqli_query($connect, "SELECT * FROM `prod_to_cat` WHERE `category_id` = '$id'");
    $data = array ();
    while ($Row = mysqli_fetch_assoc($query))
        $data[] = $Row;
    return ($data);
}

function    getIdProdToTransactionElements($id)
{
    $connect = connect_shop();
    $query = mysqli_query($connect, "SELECT * FROM `transaction_elements` WHERE `prod_id` = '$id'");
    $data = array ();
    while ($Row = mysqli_fetch_assoc($query))
        $data[] = $Row;
    return ($data);
}

function    getTransaction($token)
{
    $user_id = get_id_user_token($token);
    if (!$user_id)
        exet();
    $connect = connect_shop();
    $query = mysqli_query($connect, "SELECT * FROM `transactions`"); // LIMIT $shif, $page");
    $data = array();
    while ($row = mysqli_fetch_assoc($query))
    {
        // $categories = getIdProdToCat($row['id']);
        // foreach ($categories as $category)
        //     $row['categories'][] = $category['category_id'];
        $data[] = $row;
    }
    mysqli_close($connect);
    return ($data);
}

function    getTransactionElementProd($prod_id)
{
    $connect = connect_shop();
    $query = mysqli_query($connect, "SELECT * FROM transaction_elements WHERE `prod_id` = '$prod_id'");
    $row = mysqli_fetch_assoc($query);
    mysqli_close($connect);
    return ($row);
}

function    getTransactionsElement($trans_id)
{
    $connect = connect_shop();
    $query = mysqli_query($connect, "SELECT * FROM `transaction_elements` WHERE `trans_id` = '$trans_id'");
    $data = array ();
    while ($Row = mysqli_fetch_assoc($query))
        $data[] = $Row;
    return ($data);
}

function    getQuantity($id)
{
    $connect = connect_shop();
    $query = mysqli_query($connect, "SELECT * FROM products WHERE `id` = '$id'");
    $row = mysqli_fetch_assoc($query);
    mysqli_close($connect);
    return ($row['quantity']);
}