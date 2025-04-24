<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../config/config.php';
global $link;

ensurePostRequest();

if (empty($_POST['id'])) {
    Response::sendBadRequest('Не передан id параметр.');
}

$id = intval($_POST['id']);
$uploadDir = dirname(__DIR__, 3) . '/img/dish/';

$link->begin_transaction();
try {
    $stmt = $link->prepare("SELECT `image` FROM `dish` WHERE `id_dish` = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $current_image = $uploadDir . $stmt->get_result()->fetch_assoc()['image'];

    $stmt = $link->prepare("UPDATE `dish` SET `image` = '' WHERE `id_dish` = ?");
    $stmt->bind_param('i', $id);
    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    if (file_exists($current_image)) {
        unlink($current_image);
    }
    $link->commit();
    $link->close();
    Response::sendSuccess(['status' => true, 'description' => 'Изображение успешно удалено.']);
} catch (Exception $e) {
    $link->rollback();
    $link->close();
    Response::sendBadRequest($e->getMessage());
}
