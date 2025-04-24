<?php

require_once dirname(__DIR__) . '/database.php';

/**
 * Получение содержимого корзины
 */
function getCart(): array
{
    global $link;

    if (empty($_SESSION['cart'])) {
        return [];
    }

    $dishIds = array_keys($_SESSION['cart']);
    $placeholders = implode(', ', array_fill(0, count($dishIds), '?'));
    $types = str_repeat('i', count($dishIds));
    $stmt = $link->prepare("SELECT id_dish, dish, weight, recipes, price FROM dish WHERE id_dish IN ($placeholders)");
    $stmt->bind_param($types, ...$dishIds);
    $stmt->execute();
    $dishes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $cart = [];
    foreach ($dishes as $dish) {
        $dishId = $dish['id_dish'];
        $cart[] = [
            'id' => $dishId,
            'dish' => $dish['dish'],
            'weight' => $dish['weight'],
            'recipes' => $dish['recipes'],
            'price' => $dish['price'],
            'quantity' => $_SESSION['cart'][$dishId]['quantity'],
            'total' => $dish['price'] * $_SESSION['cart'][$dishId]['quantity'],
        ];
    }

    return $cart;
}