<?php
session_start();
require 'database.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_POST['id_dish'])) {
    $id = $_POST['id_dish'];
    $query = "SELECT * FROM dish WHERE id_dish = '$id'";
    $result = mysqli_query($link, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Если товар уже был в корзине, ув его колич
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += 1;
        } else {
            // Если не был, то добав товар в корзину с колич 1
            $_SESSION['cart'][$id] = $row;
            $_SESSION['cart'][$id]['quantity'] = 1;
        }
    }
}
header('Location: cart.php');
exit();
?>