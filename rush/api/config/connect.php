<?php
require_once "setting.php";

function    connect_shop()
{
    $connect = mysqli_connect(HOST, USER, PASS, DB);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    return ($connect);
}
?>