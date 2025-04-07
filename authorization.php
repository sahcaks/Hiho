<?php
session_start();
include 'database.php';

$name = $_POST['name_user_entry'];
$password = $_POST['password_entry'];

$passwordQuery = "SELECT `password` FROM `user` WHERE `login` = '$name'";
$idQuery = "SELECT `id_user` FROM `user` WHERE `login` = '$name'";
$saltQuery = "SELECT `salt` FROM `user` WHERE `login` = '$name'";
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
	$_SESSION['name'] = $name;
	mysqli_close($link);
} else {
	echo 'Неверный пароль';  	// ответ клиенту
}
?>