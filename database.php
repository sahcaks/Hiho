<?php
$host = "localhost"; // Хост базы данных
$database = "hiho"; // Имя базы данных
$user = "root"; // Имя пользователя
$password = ""; // Пароль (если есть)

// Подключение к БД
$link = mysqli_connect($host, $user, $password, $database);

// Проверка подключения
if (!$link) {
    die("Ошибка соединения: " . mysqli_connect_error());
}

// Установка кодировки
if (!mysqli_set_charset($link, "utf8mb4")) {
    echo "Ошибка при загрузке набора символов utf8mb4.";
    exit();
}

return $link; // Возврат соединения
?>