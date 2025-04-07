<?php
session_start();
include 'database.php';

if (isset($_POST['name_user'])) {
	$login = $_POST['name_user'];
}
if (isset($_POST['email_user'])) {
	$email_user = $_POST['email_user'];
}
if (isset($_POST['password_user'])) {
	$password_user = $_POST['password_user'];
}
if (isset($_POST['password_2_user'])) {
	$password_2_user = $_POST['password_2_user'];
}

$salt = mt_rand(100, 999);
$password = md5(md5($password_user) . $salt);
$query = "INSERT INTO `user`(`login`, `password`, `salt`, `email`) VALUES ('$login', '$password', '$salt', '$email_user')";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

if ($result) {
	$query = "SELECT * FROM `user` WHERE `login` = '$login'";
	$rez = mysqli_query($link, $query);
	if ($rez) {
		$row = mysqli_fetch_assoc($rez);
		$_SESSION['name'] = $row['login'];
		mysqli_close($link);
		print "<script language='Javascript' type='text/javascript'> 
				alert('Вы зарегистрированы');
			function reload(){top.location = 'main.php'};
			reload();
			</script>";
	}
}
?>