<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../config/config.php';
global $link;

ensurePostRequest();

$name_category = $_POST['name_category'];
$id = intval($_POST['id']);

if (empty($name_category) || empty($id)) {
    Response::sendBadRequest('Заполните все поля!');
}

$link->begin_transaction();
try {
    $stmt = $link->prepare("UPDATE category SET name_category = ? WHERE id_category = ?");
    $stmt->bind_param("si", $name_category, $id);

    if (!$stmt->execute()) {
        throw new Exception('Ошибка обновления категории: ' . $stmt->error);
    }

    $link->commit();
    $link->close();
    Response::sendSuccess(['status' => true, 'description' => 'Категория успешно обновлена!']);
} catch (Exception $e) {
    $link->rollback();
    $link->close();
    Response::sendBadRequest($e->getMessage());
}
