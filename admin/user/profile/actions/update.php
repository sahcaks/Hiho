<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../../config/config.php';
global $link;

ensurePostRequest();

$id = intval($_POST['id']);
$email = $_POST['email'];
$login = $_POST['login'];
$role_id = intval($_POST['role_id']);
$phone = $_POST['phone'];
$password = $_POST['newPassword'];
$image = $_FILES['image'];
$dir_user = dirname(__DIR__, 3) . '/img/user/' . $id;

$link->begin_transaction();
try {
    $stmt = $link->prepare("UPDATE user SET email = ?, login = ?, phone = ?, role_id = ? WHERE id_user = ?");
    $stmt->bind_param("sssii", $email, $login, $phone, $role_id, $id);

    if (!$stmt->execute()) {
        throw new Exception('Ошибка добавления пользователя: ' . $stmt->error);
    }
    if (!empty($password)) {
        $salt = mt_rand(100, 999);
        $password = md5(md5($password) . $salt);
        $stmt = $link->prepare("UPDATE user SET password = ?, salt = ? WHERE id_user = ?");
        $stmt->bind_param("sss", $password, $salt, $id);
        if (!$stmt->execute()) {
            throw new Exception('Ошибка обновления пароля: ' . $stmt->error);
        }
    }
    if (!empty($image['name'])) {
        if ($image['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Ошибка загрузки изображения.');
        }
        $image_name = basename($image['name']);
        $stmt = $link->prepare("UPDATE user SET image = ? WHERE id_user = ?");
        $stmt->bind_param("ss", $image_name, $id);
        if (!$stmt->execute()) {
            throw new Exception('Ошибка загрузки изображения: ' . $stmt->error);
        }
        if (!is_dir($dir_user)) {
            mkdir($dir_user, 0777, true);
        }
        if (!move_uploaded_file($image['tmp_name'], $dir_user . '/' . $image_name)) {
            throw new Exception('Ошибка загрузки изображения.');
        }
    }

    $link->commit();
    $stmt->close();
    Response::sendSuccess(['status' => true, 'description' => 'Пользователь успешно изменен!']);
} catch (Exception $e) {
    $link->rollback();
    $stmt->close();
    Response::sendBadRequest($e->getMessage());
}
