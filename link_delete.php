<?php
$localhost = 'localhost';
$login = 'root';
$password = '';
$db = 'link_database';
$connect = new mysqli($localhost, $login, $password, $db);

if (!$connect) {
    echo "Error: " . mysqli_connect_error();
}

if(isset($_POST["id"])) {
    $delete_link_id = mysqli_real_escape_string($connect, $_POST["id"]);
    $delete_link_sql = "DELETE FROM `link` WHERE `link`.`id` = $delete_link_id";

    if(mysqli_query($connect, $delete_link_sql)) {
        header("Location: index.php");
    } else {
        echo "Ошибка: " . mysqli_error($connect);
    }
}