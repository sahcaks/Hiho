<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../config/config.php';
global $link;

ensurePostRequest();

$name_category = $_POST['name_category'];

if (empty($name_category)) {
    Response::sendBadRequest('Укажите имя категории');
}

$link->begin_transaction();
try {
    $stmt = $link->prepare("INSERT INTO category (name_category) VALUES (?)");
    $stmt->bind_param("s", $name_category);

    if (!$stmt->execute()) {
        throw new Exception('Ошибка добавления категории: ' . $stmt->error);
    }

    $link->commit();
    $stmt->close();
    Response::sendSuccess(['status' => true, 'description' => 'Категория успешно добавлено!']);
} catch (Exception $e) {
    $link->rollback();
    $stmt->close();
    Response::sendBadRequest($e->getMessage());
}
