<?php
session_start();

if (isset($_POST['action'], $_POST['id_plant']) && $_POST['action'] == 'update') {
    $id = $_POST['id_plant'];
    $quantity = $_POST['quantity'];

    // Обновление количества
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] = $quantity;
    }
} elseif (isset($_POST['action'], $_POST['id_plant']) && $_POST['action'] == 'remove') {
    $id = $_POST['id_plant'];

    // Удаление товара
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
}

header('Location: cart.php'); // после всего обратно в корзину
exit();
?>