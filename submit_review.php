<?php
session_start();

include 'database.php';

$content = $_POST['content'];
$rating = $_POST['rating'];
$username = $_POST['username'];

// Проверяем, авторизован ли пользователь
$isLoggedIn = isset($_SESSION['name']);

if ($isLoggedIn) {
    $username = $_SESSION['name'];
}

// Записываем данные в базу данных
$query = "INSERT INTO reviews (content, rating, username, created_at) VALUES ('$content', $rating, '$username', NOW())";
$result = mysqli_query($link, $query);

if ($result) {
    echo 'success';
} else {
    echo 'error';
}
?>