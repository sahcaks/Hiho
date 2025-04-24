<?php

use app\admin\include\Response;

session_start();
require 'database.php';
require_once 'vendor/autoload.php';
require_once 'cart/functions.php';
require_once 'helper/helper.php';

global $link;

ensurePostRequest();

$name = $_SESSION['name'];
$selectQuery = "SELECT id_user FROM user WHERE login = '$name'";

$result = mysqli_query($link, $selectQuery);
$userId = null;
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $userId = (int)$row['id_user'];
    }
}

if (empty($_SESSION['cart'])) {
    Response::sendBadRequest('Корзина пуста!');
}

if (!isset($userId)) {
    Response::sendBadRequest('Вы должны быть авторизованы для оформления заказа.');
}
if (!isset($_POST['name']) || !isset($_POST['phone'])) {
    Response::sendBadRequest('Заполните все поля формы!');
}
$name = $_POST['name'];
$phone = $_POST['phone'];
$cartItems = getCart();

$total = array_sum(array_column($cartItems, 'total'));

$link->begin_transaction();

try {
    $stmt = $link->prepare("INSERT INTO orders (id_user, name, phone, total) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $userId, $name, $phone, $total);
    if (!$stmt->execute()) {
        throw new Exception('Упс! возникла непредвиденная ошибка, свяжитесь с администратором!');
    }
    $orderId = $stmt->insert_id;

    foreach ($cartItems as $item) {
        $stmt = $link->prepare("INSERT INTO order_items (order_id, dish_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiii", $orderId, $item['id'], $item['quantity'], $item['price']);
        if (!$stmt->execute()) {
            throw new Exception('Упс! возникла непредвиденная ошибка, свяжитесь с администратором!');
        }
    }
    calculateAndAddBonuses($link, $userId, $orderId, $total);
    $link->commit();
    unset($_SESSION['cart']);
    Response::sendSuccess(['status' => true, 'description' => 'Заказ успешно оформлен!']);
} catch (Exception $e) {
    $link->rollback();
    Response::sendBadRequest($e->getMessage());
}

/**
 * @throws Exception
 */
function calculateAndAddBonuses($mysqli, $userId, $orderId, $orderTotal): array
{
    try {
        $orderTotal = str_replace(',', '.', $orderTotal);

        $orderTotal = (float)$orderTotal;

        $bonusRate = 0.10;

        $bonusPoints = $orderTotal * $bonusRate;

        $updateQuery = "UPDATE user SET bonus_balance = bonus_balance + ? WHERE id_user = ?";
        $stmt = $mysqli->prepare($updateQuery);
        $stmt->bind_param('di', $bonusPoints, $userId);

        if (!$stmt->execute()) {
            throw new Exception("Ошибка начисления бонусов: " . $stmt->error);
        }
        $insertQuery = "INSERT INTO user_rewards (user_id, order_id, reward_points, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $mysqli->prepare($insertQuery);

        $stmt->bind_param('iid', $userId, $orderId, $bonusPoints);
        if (!$stmt->execute()) {
            throw new Exception("Ошибка начисления бонусов: " . $stmt->error);
        }

        return [
            'success' => true,
            'message' => "Начислено {$bonusPoints} бонусов.",
        ];
    } catch (Exception $e) {
        throw new Exception($e);
    }
}
