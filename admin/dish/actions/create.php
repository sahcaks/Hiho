<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../config/config.php';
global $link;

ensurePostRequest();

$id_category = $_POST['id_category'];
$dish = $_POST['dish'];
$weight = $_POST['weight'];
$recipes = $_POST['recipes'];
$price = $_POST['price'];
$image = $_FILES['image'];

if ($image['error'] !== UPLOAD_ERR_OK) {
    Response::sendBadRequest('Ошибка загрузки изображения.');
}

$image_name = basename($image['name']);

$link->begin_transaction();
try {
    $stmt = $link->prepare("INSERT INTO dish (id_category, dish, weight, recipes, price, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssds", $id_category, $dish, $weight, $recipes, $price, $image_name);

    if (!$stmt->execute()) {
        throw new Exception('Ошибка добавления блюда: ' . $stmt->error);
    }


    move_uploaded_file($image['tmp_name'], dirname(__DIR__, 3) . '/img/dish/' . $image_name);

    $link->commit();
    $stmt->close();
    Response::sendSuccess(['status' => true, 'description' => 'Блюдо успешно добавлено!']);
} catch (Exception $e) {
    $link->rollback();
    $stmt->close();
    Response::sendBadRequest($e->getMessage());
}
