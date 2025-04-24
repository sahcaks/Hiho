<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../config/config.php';
global $link;

ensurePostRequest();

$roleName = $_POST['role_name'] ?? '';

if (empty($roleName)) Response::sendBadRequest('Имя роли не может быть пустым.');

$link->begin_transaction();
try {
    $stmt = $link->prepare("INSERT INTO roles (role_name) VALUES (?)");
    $stmt->bind_param("s", $roleName);

    if (!$stmt->execute()) {
        throw new Exception('Ошибка добавления роли: ' . $stmt->error);
    }
    $link->commit();
    $stmt->close();
    Response::sendSuccess(['status' => true, 'description' => 'Роль успешно добавлена!']);
} catch (Exception $e) {
    $link->rollback();
    Response::sendBadRequest($e->getMessage());
}