<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../config/config.php';
global $link;

ensurePostRequest();

if (empty($_POST['blocks'])) {
    Response::sendBadRequest('Нет данных для обновления');
}
$data = json_decode($_POST['blocks'], true);

try {
    $link->begin_transaction();

    $stmt = $link->prepare("
            UPDATE table_positions 
            SET x_coordinate = ?, y_coordinate = ?, width = ?, height = ? 
            WHERE table_id = ?
        ");

    foreach ($data as $block) {
        $stmt->bind_param('sssss', $block['x'], $block['y'], $block['width'], $block['height'], $block['id']);
        if (!$stmt->execute()) {
            throw new Exception('Упс! произошла ошибка, обратитесь к администратору!');
        }
    }

    $link->commit();

    Response::sendSuccess(['status' => true, 'description' => 'Координаты успешно изменены.']);
} catch (PDOException $e) {
    $link->rollBack();
    Response::sendError($e->getCode(), $e->getMessage());
}

