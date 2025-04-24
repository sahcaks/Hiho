<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../config/config.php';
global $link;

ensurePostRequest();

$uploadDir = dirname(__DIR__, 3) . '/img/dish/';

if (!isset($_FILES['image'])) {
    Response::sendBadRequest('Файл не был передан.');
}
$file = $_FILES['image'];
$id = intval($_POST['id']);

if ($file['error'] !== UPLOAD_ERR_OK) {
    Response::sendBadRequest('Ошибка загрузки файла.');
}
if (empty($id)) {
    Response::sendBadRequest('Не передан id параметр.');
}

$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];

/*$maxFileSize = 2 * 1024 * 1024; // 2MB*/
/*if ($file['size'] > $maxFileSize) {
    $response['message'] = 'Файл слишком большой. Максимальный размер — 2MB.';
    echo json_encode($response);
    exit;
}*/

if (!in_array($file['type'], $allowedTypes)) {
    Response::sendBadRequest('Неверный тип файла. Поддерживаются JPG, JPEG, PNG и GIF.');
}

$file_name = basename($file['name']);
$target_path = $uploadDir . $file_name;

$link->begin_transaction();
try {
    $stmt = $link->prepare("SELECT `image` FROM `dish` WHERE `id_dish` = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $image = $stmt->get_result()->fetch_assoc()['image'];
    $current_image = $uploadDir . $image;

    $stmt = $link->prepare("UPDATE `dish` SET `image` = ? WHERE `id_dish` = ?");
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
