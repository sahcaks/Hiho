<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $action = $data['action'] ?? '';

    if ($action === 'update') {
        // Рассчитываем общую сумму
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            if (intval($item['id_dish']) === intval($data['id'])) {
                $_SESSION['cart'][$item['id_dish']]['quantity'] = $data['quantity'];
                $item['quantity'] = intval($data['quantity']);
            }
            $total += $item['price'] * $item['quantity'];
            $_SESSION['total'] = $total;
        }
        echo json_encode(['success' => true, 'total' => number_format($total, 2)]);
        exit;
    }

    if ($action === 'remove') {
        unset($_SESSION['cart'][$data['id_dish']]);
        echo json_encode(['success' => true]);
        exit;
    }
}

// Отображение текущей корзины
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(['cart' => $_SESSION['cart'], 'total' => $_SESSION['total']]);
}