<?php

use app\admin\include\Response;
use app\helper\Enum\TableStatusEnum;

session_start();

require_once dirname(__DIR__) . '/../config/config.php';
global $link;

ensurePostRequest();

$status = intval($_POST["status"]);
$table_id = intval($_POST["table_id"]);
$reservation_id = intval($_POST["reservation_id"]);

$link->begin_transaction();

try {
    $stmt1 = $link->prepare("UPDATE tables SET status = ? WHERE id = ?");
    $stmt1->bind_param('ii', $status, $table_id);

    if (!$stmt1->execute()) {
        throw new Exception('Упс! возникла непредвиденная ошибка, свяжитесь с администратором!');
    }

    if ($status === TableStatusEnum::OPEN) {
        $stmt2 = $link->prepare("DELETE FROM reservations WHERE id = ?");
        $stmt2->bind_param('i', $reservation_id);
        if (!$stmt2->execute()) {
            throw new Exception('Упс! возникла непредвиденная ошибка, свяжитесь с администратором!');
        }
    }

    $link->commit();
    $link->close();

    Response::sendSuccess(['status' => true, 'description' => 'Статус успешно обновлён!']);
} catch (Exception $e) {
    $link->rollback();
    $link->close();
    Response::sendBadRequest($e->getMessage());
}

