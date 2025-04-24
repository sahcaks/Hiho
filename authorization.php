<?php
global $link;
session_start();
include 'database.php';
require_once 'helper/helper.php';

$name = $_POST['name_user_entry'];
$password = $_POST['password_entry'];

$passwordQuery = "SELECT `password` FROM `user` WHERE `login` = '$name'";
$idQuery = "SELECT `id_user` FROM `user` WHERE `login` = '$name'";
$saltQuery = "SELECT `salt` FROM `user` WHERE `login` = '$name'";
$roleIdQuery = "SELECT `role_id` FROM `user` WHERE `login` = '$name'";
$passwordResult = mysqli_query($link, $passwordQuery) or die ("Ошибка выполнения запроса1" . mysqli_error($link));
$saltResult = mysqli_query($link, $saltQuery) or die ("Ошибка выполнения запроса2" . mysqli_error($link));
if ($passwordResult && $saltResult) {
    $passworsRow = mysqli_fetch_row($passwordResult);
    $saltRow = mysqli_fetch_row($saltResult);
    if (md5(md5($password) . $saltRow[0]) == $passworsRow[0]) {
        $userExists = true;
    } else {
        $userExists = false;
    }
}
$idResult = mysqli_query($link, $idQuery) or die ("Ошибка выполнения запроса1" . mysqli_error($link));
if ($idResult) {
    $idRow = mysqli_fetch_row($idResult);
    $_SESSION['id_user'] = $idRow[0];
}
if ($userExists) {
    $result = mysqli_query($link, $roleIdQuery);
    $roleId = mysqli_fetch_row($result);
    $_SESSION['name'] = $name;
    $_SESSION['role_id'] = $roleId[0];
    $_SESSION['cart'] = [];
    mysqli_close($link);
    if ($roleId[0] == '3') {
        $data = ['redirect_url' => "http://localhost:8888/hiho/admin/"];
    } else {
        $data = ['redirect_url' => "http://localhost:8888/hiho/"];
    }
    echo json_encode($data);
} else {
    echo 'Неверный пароль';    // ответ клиенту
}
?>