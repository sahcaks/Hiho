<?php
session_start();

require_once __DIR__ . "../../../database.php";
require_once __DIR__ . "../../../helper/helper.php";
require_once __DIR__ . "../../include/response.php";
global $link;

ensurePostRequest();


$json = file_get_contents('php://input');
$data = json_decode($json, true);

$status = (int)$data["status"];
$id = (int)$data["id"];

$link->begin_transaction();

try {
    $stmt = $link->prepare("
        UPDATE tables SET status = ? WHERE id = ?
    ");
    $stmt->bind_param('ii', $status, $id);

    if (!$stmt->execute()) {
        throw new Exception('Упс! возникла непредвиденная ошибка, свяжитесь с администратором!');
    }
    $link->commit();

    Response::sendSuccess(['status' => true, 'description' => 'Статус успешно обновлён!']);
} catch (Exception $e) {
    $link->rollback();
    Response::sendBadRequest($e->getMessage());
}

