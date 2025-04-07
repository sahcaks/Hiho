<?php
session_start();
require 'database.php';

// Готовим SQL-запрос для получения ID по имени пользователя
$name = $_SESSION['name'];
$selectQuery = "SELECT id_user FROM user WHERE login = '$name'";

// Выполняем запрос
$result = mysqli_query($link, $selectQuery);

if ($result) {
    // Проверяем, есть ли результаты запроса
    if (mysqli_num_rows($result) > 0) {
        // Извлекаем данные из результата запроса
        $row = mysqli_fetch_assoc($result);
        $id_user = $row['id_user'];
    }
}
if (isset ($_POST['name'], $_POST['phone'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $cartItems = $_SESSION['cart']; // Получаем массив товаров из сессии
    $serializedCart = serialize($cartItems);
    // Запрос к БД для добавления заказа
    $query = "INSERT INTO orders (name, phone, cart_items, id_user) VALUES ('$name', '$phone', '$serializedCart', $id_user)";
    $result2 = mysqli_query($link, $query);
    if ($result2) {
        echo "Заказ успешно оформлен";
        unset($_SESSION['cart']);

    } else {
        echo "Заказ не оформлен";
    }
} else {
    echo "Необходимо заполнить все поля формы.";
}

$link->close();
?>