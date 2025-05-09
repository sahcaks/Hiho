<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../config/config.php';

ensurePostRequest();

$date = $_POST["date"] ?? null;
$time_start = $_POST["time_start"] ?? null;
$time_end = $_POST["time_end"] ?? null;
$reservation_id = intval($_POST["id"]);

if (!empty($date)) {
    $datetime = new DateTime($date);
    updateDate($datetime, $reservation_id);
} else if (!empty($time_start)) {
    updateTimeStart($time_start, $reservation_id);
} else if (!empty($time_end)) {
    updateTimeEnd($time_end, $reservation_id);
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

function updateTimeStart($time, int $reservation_id): void
{
    global $link;
    $link->begin_transaction();

    try {
        $stmt = $link->prepare("UPDATE reservations SET time_start = ? WHERE id = ?");
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

function updateTimeEnd($time, int $reservation_id): void
{
    global $link;
    $link->begin_transaction();

    try {
        $stmt = $link->prepare("UPDATE reservations SET time_end = ? WHERE id = ?");
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