<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../config/config.php';
global $link;

ensurePostRequest();

if (!isset($_POST['id'])) {
    Response::sendBadRequest('ID не был передан');
}
$id = intval($_POST['id']);


$link->begin_transaction();
try {
    $stmt = $link->prepare("DELETE FROM category WHERE id_category = ?");
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        Response::sendBadRequest('Ошибка удаления категории: ' . $stmt->error);
    }
    $link->commit();
    $link->close();
    Response::sendSuccess(['status' => true, 'description' => 'Категория успешно удалена!']);
} catch (Exception $e) {
    $link->rollback();
    $link->close();
    Response::sendBadRequest($e->getMessage());
}
