<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../config/config.php';
global $link;

ensurePostRequest();

$content = $_POST['content'];
$rating = intval($_POST['rating']);
$username = $_POST['username'];

$link->begin_transaction();
try {
    $stmt = $link->prepare("INSERT INTO reviews (content, rating, username) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $content, $rating, $username);

    if (!$stmt->execute()) {
        throw new Exception('Ошибка добавления отзыва: ' . $stmt->error);
    }

    $link->commit();
    $stmt->close();
    Response::sendSuccess(['status' => true, 'description' => 'Отзыв успешно добавлен!']);
} catch (Exception $e) {
    $link->rollback();
    $stmt->close();
    Response::sendBadRequest($e->getMessage());
}
