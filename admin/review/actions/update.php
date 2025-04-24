<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../config/config.php';
global $link;

ensurePostRequest();

$content = $_POST['content'];
$rating = intval($_POST['rating']);
$username = $_POST['username'];
$id = intval($_POST['id']);

$link->begin_transaction();
try {
    $stmt = $link->prepare("UPDATE reviews SET content = ?, rating = ?, username = ? WHERE id = ?");
    $stmt->bind_param("sisi", $content, $rating, $username, $id);

    if (!$stmt->execute()) {
        throw new Exception('Ошибка обновления отзыва: ' . $stmt->error);
    }

    $link->commit();
    $link->close();
    Response::sendSuccess(['status' => true, 'description' => 'Отзыв успешно обновлен!']);
} catch (Exception $e) {
    $link->rollback();
    $link->close();
    Response::sendBadRequest($e->getMessage());
}
