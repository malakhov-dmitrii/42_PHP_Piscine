<?php

require_once "config/connect.php";
require_once "get.php";
require_once "update.php";

function    setReg($data)
{
    $connect = connect_shop();
    $name = $data['name'];
    $lastname = $data['lastname'];
    $login = $data['login'];
    $email = $data['email'];
    $address = $data['address'];
    $passwd = $data['passwd'];
    mysqli_query($connect, "INSERT INTO users VALUES(NULL, '$name', '$lastname', '$login', '$email', '$address', '$passwd', 0, '')");
    mysqli_close($connect);
}

function    setCat($data)
{
    $connect = connect_shop();
    $name = $data['name'];
    $description = $data['description'];
    $img = $data['img'];
    mysqli_query($connect, "INSERT INTO cat_list VALUES(NULL, '$name', '$description', '$img')");
    mysqli_close($connect);
}

function    setProdToCat($Cat, $Prod)
{
    $connect = connect_shop();
    mysqli_query($connect, "INSERT INTO prod_to_cat VALUES(NULL, '$Cat', '$Prod')");
    mysqli_close($connect);
}

function    setGoods($data)
{
    $connect = connect_shop();
    $name = $data['name'];
    $quantity = $data['quantity'];
    $value = $data['value'];
    $description = $data['description'];
    $img = $data['img'];
    mysqli_query($connect, "INSERT INTO products VALUES(NULL, '$name', '$quantity', '$value', '$description', '$img')");
    $id = mysqli_insert_id($connect);
    mysqli_close($connect);
    return ($id);
}

function    setTransaction($data)
{
    $connect = connect_shop();
    $user_id = get_id_user_token($data['token']);
    $commentary = $data['commentary'];
    if (!$data['payment'])
        $payment = "cash";
    else
        $payment = "card";
    mysqli_query($connect, "INSERT INTO transactions VALUES(NULL, '$user_id', '$commentary', 'delivered', '$payment')");
    $id = mysqli_insert_id($connect);
    mysqli_close($connect);
    return ($id);
}



function    setTransactionElements($prod, $idTransaction)
{
    $connect = connect_shop();
    $prod_id = $prod['id'];
    $count = $prod['count'];
    $price = get_store('products', $prod_id);
    $total_price = $price["prod_value"] * $count;
    mysqli_query($connect, "INSERT INTO transaction_elements VALUES(NULL, '$idTransaction', '$prod_id', '$count', '$total_price')");
    $count = getQuantity($prod['id']) - $prod['count'];
    updateQuantity($count, $prod['id']);
    $id = mysqli_insert_id($connect);
    mysqli_close($connect);
    return ($id);
}
