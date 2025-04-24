<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../config/config.php';
global $link;

ensurePostRequest();

$roleId = $_POST['id'] ?? null;
$roleName = $_POST['role_name'] ?? '';

if (empty($roleId) || empty($roleName)) {
    Response::sendBadRequest('ID и имя роли не могут быть пустыми.');
}

$link->begin_transaction();
try {
    $stmt = $link->prepare("UPDATE roles SET role_name = ? WHERE id = ?");
    $stmt->bind_param("si", $roleName, $roleId);

    if (!$stmt->execute()) {
        throw new Exception('Ошибка обновления роли: ' . $stmt->error);
    }
    $link->commit();
    $stmt->close();
    Response::sendSuccess(['status' => true, 'description' => 'Роль успешно обновлена!']);
} catch (Exception $e) {
    $link->rollback();
    Response::sendError($e->getCode(), $e->getMessage());
}