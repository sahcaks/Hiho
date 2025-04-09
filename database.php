<?php
$host = "localhost";
$database = "hiho";
$user = "root";
$password = "root";
$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

if (!mysqli_set_charset($link, "utf8mb4")) {
    echo "Ошибка при загрузке набора символов utf8mb4 ";
    mysqli_error($link);
    exit();
}
?>