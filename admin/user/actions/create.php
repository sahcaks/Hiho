<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../config/config.php';
global $link;

ensurePostRequest();

$email = $_POST['email'];
$login = $_POST['login'];
$role_id = $_POST['role_id'];
$phone = $_POST['phone'];
$password = $_POST['newPassword'];
$salt = mt_rand(100, 999);
$password = md5(md5($password) . $salt);
$image = $_FILES['image'];

if ($image['error'] !== UPLOAD_ERR_OK) {
    Response::sendBadRequest('Ошибка загрузки изображения.');
}

$image_name = basename($image['name']);

$link->begin_transaction();
try {
    $stmt = $link->prepare("INSERT INTO user (email, login, phone, role_id, salt, password, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisss", $email, $login, $phone, $role_id, $salt, $password, $image_name);

    if (!$stmt->execute()) {
        throw new Exception('Ошибка добавления пользователя: ' . $stmt->error);
    }
    $user_id = $link->insert_id;
    $dir_user = dirname(__DIR__, 3) . '/img/user/' . $user_id;
    if (!is_dir($dir_user)) {
        mkdir($dir_user, 0777, true);
    }
    if (!move_uploaded_file($image['tmp_name'], $dir_user . '/' . $image_name)) {
        throw new Exception('Ошибка загрузки изображения.');
    }

    $link->commit();
    $stmt->close();
    Response::sendSuccess(['status' => true, 'description' => 'Пользователь успешно добавлен!']);
} catch (Exception $e) {
    $link->rollback();
    $stmt->close();
    Response::sendBadRequest($e->getMessage());
}
