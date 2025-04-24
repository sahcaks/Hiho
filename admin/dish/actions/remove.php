<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../config/config.php';
global $link;

ensurePostRequest();

if (!isset($_POST['id'])) {
    Response::sendBadRequest('ID не был передан');
}

$link->begin_transaction();
try {
    $id = (int)$_POST['id'];
    $stmt = $link->prepare("SELECT image FROM dish WHERE id_dish = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $imagePath = dirname(__DIR__, 3) . '/img/dish/';
    $image_name = $stmt->get_result()->fetch_assoc()['image'];
    $stmt = $link->prepare("DELETE FROM dish WHERE id_dish = ?");
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        Response::sendBadRequest('Ошибка удаления блюда: ' . $stmt->error);
    }
    if ($imagePath && file_exists($imagePath . $image_name)) {
        unlink($imagePath . $image_name);
    }
    $link->commit();
    $link->close();
    Response::sendSuccess(['status' => true, 'description' => 'Блюдо успешно удалено!']);
} catch (Exception $e) {
    $link->rollback();
    $link->close();
    Response::sendBadRequest($e->getMessage());
}
