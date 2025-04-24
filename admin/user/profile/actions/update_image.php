<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../../config/config.php';
global $link;

ensurePostRequest();
$id = intval($_POST['id']);
$uploadDir = dirname(__DIR__, 4) . '/img/user/' . $id . '/';

if (!isset($_FILES['image'])) {
    Response::sendBadRequest('Файл не был передан.');
}
$file = $_FILES['image'];


if ($file['error'] !== UPLOAD_ERR_OK) {
    Response::sendBadRequest('Ошибка загрузки файла.');
}
if (empty($id)) {
    Response::sendBadRequest('Не передан id параметр.');
}

$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];

if (!in_array($file['type'], $allowedTypes)) {
    Response::sendBadRequest('Неверный тип файла. Поддерживаются JPG, JPEG, PNG и GIF.');
}

$file_name = basename($file['name']);
$target_path = $uploadDir . $file_name;

$link->begin_transaction();
try {
    $stmt = $link->prepare("SELECT `image` FROM `user` WHERE `id_user` = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $image = $stmt->get_result()->fetch_assoc()['image'];
    $current_image = $uploadDir . $image;

    $stmt = $link->prepare("UPDATE `user` SET `image` = ? WHERE `id_user` = ?");
    $stmt->bind_param('si', $file_name, $id);
    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    if (!empty($image) && file_exists($current_image)) {
        unlink($current_image);
    }
    if (!move_uploaded_file($file['tmp_name'], $target_path)) {
        throw new Exception('Не удалось сохранить файл.');
    }

    $link->commit();
    $link->close();
    Response::sendSuccess(['status' => true, 'description' => 'Изображение успешно обновлено.']);
} catch (Exception $e) {
    $link->rollback();
    $link->close();
    Response::sendBadRequest($e->getMessage());
}
