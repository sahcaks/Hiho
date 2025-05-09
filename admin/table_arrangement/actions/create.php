<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../config/config.php';
global $link;

ensurePostRequest();

$phone = $_POST["phone"];
$name = $_POST["name"];
$date = $_POST["date"];
$time_start = (new DateTime($_POST["time_start"]))->format('H:i');
$time_end = (new DateTime($_POST["time_end"]))->format('H:i');
$capacity = $_POST["capacity"];
$status = $_POST["status"];
$table_id = $_POST["table_id"];
$comments = $_POST["comments"];

$link->begin_transaction();

try {
    if (isReservationExists($table_id, $date, $time_start, $time_end)) {
        throw new Exception('На это время стол №: ' . $table_id . ' зарезервирован, выберите другой.');
    }
    $stmt1 = $link->prepare("INSERT INTO reservations (phone, name, date, time_start, time_end, capacity, comments, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param("sssssiss", $phone, $name, $date, $time_start, $time_end, $capacity, $comments, $status);

    if (!$stmt1->execute()) {
        throw new Exception('Упс! возникла непредвиденная ошибка, свяжитесь с администратором!');
    }
    $reservation_id = $link->insert_id;
    $stmt2 = $link->prepare("INSERT INTO table_reservations (reservation_id, table_id) VALUES (?, ?)");
    $stmt2->bind_param("ii", $reservation_id, $table_id);
    if (!$stmt2->execute()) {
        throw new Exception('Упс! возникла непредвиденная ошибка, свяжитесь с администратором!');
    }

    $link->commit();

    Response::sendSuccess(['status' => true, 'description' => 'Бронь успешно создана!']);
} catch (Exception $e) {
    $link->rollback();
    Response::sendBadRequest($e->getMessage());
}

/**
 * @throws Exception
 */
function isReservationExists($table_id, $date, $time_start, $time_end): bool
{
    global $link;
    try {
        $stmt = $link->prepare("SELECT COUNT(*) as count
                                        FROM reservations as r
                                                 INNER JOIN table_reservations as tr ON tr.reservation_id = r.id AND tr.table_id = ?
                                        WHERE r.date = ?
                                          AND r.time_start <= ?
                                          AND r.time_end >= ?");
        $stmt->bind_param("isss", $table_id,$date, $time_start, $time_end);
        if (!$stmt->execute()) {
            throw new Exception('Упс! возникла непредвиденная ошибка, свяжитесь с администратором!');
        }
        return $stmt->get_result()->fetch_assoc()['count'] > 0;
    } catch (\Exception $exception) {
        throw new Exception($exception->getMessage());
    }
}