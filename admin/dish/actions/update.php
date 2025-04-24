<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../config/config.php';
global $link;

ensurePostRequest();

$id = intval($_POST['id']);
$id_category = intval($_POST['id_category']);
$dish = $_POST['dish'];
$weight = $_POST['weight'];
$recipes = $_POST['recipes'];
$price = $_POST['price'];
$image = $_FILES['image'];

if ($image['error'] !== UPLOAD_ERR_OK) {
    Response::sendBadRequest('Имя роли не может быть пустым.');
}

$image_name = basename($image['name']);
$upload_path = dirname(__DIR__, 3) . '/img/dish/';
$link->begin_transaction();
try {
    $stmt = $link->prepare("UPDATE dish SET id_category = ?, dish = ?, weight = ?, recipes = ?, price = ?, image = ? WHERE id_dish = ?");
    $stmt->bind_param("isssdsi", $id_category, $dish, $weight, $recipes, $price, $image_name, $id);

    if (!$stmt->execute()) {
        throw new Exception('Ошибка добавления блюда: ' . $stmt->error);
    }

    if (!move_uploaded_file($image['tmp_name'], $upload_path . $image_name)) {
        throw new Exception('Не удалось сохранить файл.');
    }

    $link->commit();
    $link->close();
    Response::sendSuccess(['status' => true, 'description' => 'Блюдо успешно обновлено!']);
} catch (Exception $e) {
    $link->rollback();
    $link->close();
    Response::sendBadRequest($e->getMessage());
}