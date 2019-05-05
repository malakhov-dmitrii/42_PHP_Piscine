<?php

function    modifyUser($data)
{
    $connect = connect_shop();
    $id = $data['id'];
    $user_name = $data['name'];
    $user_lastname = $data['lastname'];
    $user_login = $data['login'];
    $email = $data['email'];
    $user_address = $data['address'];
    $user_passwd = $data['passwd'];
    $is_admin = $data['admin'];
    mysqli_query($connect, "UPDATE users SET 
                            user_name = '$user_name',
                            user_lastname = '$user_lastname',
                            user_login = '$user_login',
                            email = '$email',
                            user_address = '$user_address',
                            user_passwd = '$user_passwd',
                            is_admin = '$is_admin'
                        WHERE id = '$id'");
    mysqli_close($connect);
}

function    modifyProduct($data)
{
    $connect = connect_shop();
    $id = $data['id'];
    $prod_name = $data['name'];
    $quantity = $data['quantity'];
    $prod_value = $data['value'];
    $prod_description = $data['description'];
    $product_image = $data['img'];
    mysqli_query($connect, "UPDATE products SET 
                            prod_name = '$prod_name',
                            quantity = '$quantity',
                            prod_value = '$prod_value',
                            prod_description = '$prod_description',
                            product_image = '$product_image'
                        WHERE id = '$id'");
    mysqli_close($connect);
}

function    modifyCat($data)
{
    $connect = connect_shop();
    $id = $data['id'];
    $category_name = $data['name'];
    $cat_description = $data['description'];
    $cat_img = $data['img'];
    mysqli_query($connect, "UPDATE cat_list SET 
                            category_name = '$category_name',
                            cat_description = '$cat_description',
                            cat_img = '$cat_img'
                        WHERE id = '$id'");
    mysqli_close($connect);
}
