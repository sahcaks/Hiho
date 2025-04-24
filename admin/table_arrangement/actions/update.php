<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../config/config.php';

ensurePostRequest();

$date = $_POST["date"] ?? null;
$time = $_POST["time"] ?? null;
$reservation_id = intval($_POST["id"]);

if (!empty($date)) {
    $datetime = new DateTime($date);
    updateDate($datetime, $reservation_id);
} else if (!empty($time)) {
    updateTime($time, $reservation_id);
} else {
    Response::sendBadRequest('Параметры не были переданы.');
}
function updateDate(Datetime $date, int $reservation_id): void
{
    global $link;
    $link->begin_transaction();

    try {
        $datetime = $date->format("Y-m-d");
        $stmt = $link->prepare("UPDATE reservations SET date = ? WHERE id = ?");
        $stmt->bind_param("si", $datetime, $reservation_id);
        if (!$stmt->execute()) {
            throw new Exception('Упс! возникла непредвиденная ошибка, свяжитесь с администратором!');
        }

        $link->commit();

        Response::sendSuccess(['status' => true, 'description' => 'Бронь успешно обновлена!']);
    } catch (Exception $e) {
        $link->rollback();
        Response::sendBadRequest($e->getMessage());
    }
}

function updateTime($time, int $reservation_id): void
{
    global $link;
    $link->begin_transaction();

    try {
        $stmt = $link->prepare("UPDATE reservations SET time = ? WHERE id = ?");
        $stmt->bind_param("si", $time, $reservation_id);
        if (!$stmt->execute()) {
            throw new Exception('Упс! возникла непредвиденная ошибка, свяжитесь с администратором!');
        }

        $link->commit();

        Response::sendSuccess(['status' => true, 'description' => 'Бронь успешно обновлена!']);
    } catch (Exception $e) {
        $link->rollback();
        Response::sendBadRequest($e->getMessage());
    }
}