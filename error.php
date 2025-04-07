<?php
include 'database.php';
$errorContainer = array();

function clearString($str)
{
	$str = trim($str);
	$str = strip_tags($str);
	$str = stripslashes($str);
	return $str;
}

$nameError = ''; 	// валидация на регистрацию
$name = $_POST["name_user"];
clearString($name);

$query_nicknames = "SELECT `login` FROM `user`";
$nicknames_coincidence = false;
$result_nicknames = mysqli_query($link, $query_nicknames) or die("Ошибка запроса" . mysqli_error($link));
if ($result_nicknames) {
	$rows = mysqli_num_rows($result_nicknames);
	for ($i = 0; $i < $rows; ++$i) {
		$row = mysqli_fetch_assoc($result_nicknames);
		if ($name == $row['login']) {
			$nicknames_coincidence = $row['login'];
		}
	}
}
;

if ($name == '') {
	$nameError = "Поле не должно быть пустым ";
	$errorContainer['name_user'] = $nameError;
} else if (!preg_match('/^\w{3,}$/u', $name)) {
	$nameError = "Короткое имя";
	$errorContainer['name_user'] = $nameError;
} else if ($nicknames_coincidence) {
	$nameError = "Данный пользователь уже существует";
	$errorContainer['name_user'] = $nameError;
} else {
	$errorContainer['name_user'] = false;
}
;

$firstPasswordError = '';
$firstPassword = $_POST["password_user"];
clearString($firstPassword);
if ($firstPassword == '') {
	$firstPasswordError = "Поле не должно быть пустым";
	$errorContainer['password_user'] = $firstPasswordError;
} else if (!preg_match('/^\w{8,}$/u', $firstPassword)) {
	$firstPasswordError = "Слишком короткий пароль";
	$errorContainer['password_user'] = $firstPasswordError;
} else if (!preg_match('/\d+/u', $firstPassword)) {
	$firstPasswordError = "Пароль должен включать цифры";
	$errorContainer['password_user'] = $firstPasswordError;
} else {
	$errorContainer['password_user'] = false;
}
;

$secondPasswordError = '';
$secondPassword = $_POST["password_2_user"];
clearString($secondPassword);
if ($secondPassword == '') {
	$secondPasswordError .= "Поле не должно быть пустым";
	$errorContainer['password_2_user'] = $secondPasswordError;
} else if ($secondPassword != $firstPassword) {
	$secondPasswordError .= "Пароли не совпадают";
	$errorContainer['password_2_user'] = $secondPasswordError;
} else if ($secondPassword == $firstPassword) {
	$errorContainer['password_2_user'] = false;
}
;

if ($firstPassword == $secondPassword) {
	$errorContainer['password_2_user'] = false;
}

$emailError = '';
$email = $_POST["email_user"];
clearString($email);

$query_emails = "SELECT `id_user` FROM `user` WHERE `email` = '$email'";
$result_emails = mysqli_query($link, $query_emails) or die("Ошибка запроса" . mysqli_error($link));
if ($result_emails) {
	$rows = mysqli_num_rows($result_emails);
	if ($rows == null) {
		$emails_coincidence = false;
	} else {
		$emails_coincidence = true;
	}
	;
}
;

if ($email == '') {
	$emailError = "Поле не должно быть пустым";
	$errorContainer['email_user'] = $emailError;
} else if (!preg_match('/[A-Za-z]+/u', $email)) {
	$emailError = "Email должен состоять из букв английского алфавита";
	$errorContainer['email_user'] = $emailError;
} else if (!preg_match('/[@]{1}/u', $email)) {
	$emailError = "Email должен содержать один символ '@'";
	$errorContainer['email_user'] = $emailError;
} else if (!preg_match('/^\w+([\.\w]+)*\w@\w((\.\w)*\w+)*\.\w{2,3}$/u', $email)) {
	$emailError = "Введенный email не корректный";
	$errorContainer['email_user'] = $emailError;
} else if ($emails_coincidence) {
	$emailError = "Пользователь с таким email уже есть";
	$errorContainer['email_user'] = $emailError;
} else {
	$errorContainer['email_user'] = false;
}
;

$nameError_entry = '';	// валидация на вход
$name_entry = $_POST["name_user_entry"];
clearString($name_entry);

$nicknames_coincidence_entry = false;
$result_nicknames = mysqli_query($link, $query_nicknames) or die("Ошибка запроса" . mysqli_error($link));
if ($result_nicknames) {
	$rows = mysqli_num_rows($result_nicknames);
	for ($i = 0; $i < $rows; ++$i) {
		$row = mysqli_fetch_assoc($result_nicknames);
		if ($name_entry == $row['login']) {
			$nicknames_coincidence_entry = true;
		}
	}
}
;

if ($name_entry == '') {
	$nameError_entry = "Поле не должно быть пустым";
	$errorContainer['name_user_entry'] = $nameError_entry;
} else if (!$nicknames_coincidence_entry) {
	$nameError_entry = "Пользователя с таким именем нет";
	$errorContainer['name_user_entry'] = $nameError_entry;
} else {
	$errorContainer['name_user_entry'] = false;
}
;

$enterPasswordError = '';
$enterPassword = $_POST["password_entry"];
clearString($enterPassword);
if ($enterPassword == '') {
	$enterPasswordError .= "Поле не должно быть пустым";
	$errorContainer['password_entry'] = $enterPasswordError;
} else {
	$errorContainer['password_entry'] = false;
}
;
echo json_encode(array('result' => 'error', 'text_error' => $errorContainer)); // ответ для клиента
?>