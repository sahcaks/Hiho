<?php

use app\admin\include\Response;

session_start();

require_once dirname(__DIR__) . '/../../config/config.php';
global $link;

ensurePostRequest();

$phone = $_POST["phone"];
$name = $_POST["name"];
$date = $_POST["date"];
$time = $_POST["time"];
$capacity = $_POST["capacity"];
$status = $_POST["status"];
$table_id = $_POST["table_id"];
$comments = $_POST["comments"];

$link->begin_transaction();

try {
    $stmt1 = $link->prepare("INSERT INTO reservations (phone, name, date, time, capacity, comments) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param("ssssis", $phone, $name, $date, $time, $capacity, $comments);

    if (!$stmt1->execute()) {
        throw new Exception('Упс! возникла непредвиденная ошибка, свяжитесь с администратором!');
    }
    $reservation_id = $link->insert_id;
    $stmt2 = $link->prepare("INSERT INTO table_reservations (reservation_id, table_id) VALUES (?, ?)");
    $stmt2->bind_param("ii", $reservation_id, $table_id);
    if (!$stmt2->execute()) {
        throw new Exception('Упс! возникла непредвиденная ошибка, свяжитесь с администратором!');
    }

    $stmt3 = $link->prepare("UPDATE tables SET status = ? WHERE id = ?");
    $stmt3->bind_param("ii", $status, $table_id);
    if (!$stmt3->execute()) {
        throw new Exception('Упс! возникла непредвиденная ошибка, свяжитесь с администратором!');
    }

    $link->commit();

    Response::sendSuccess(['status' => true, 'description' => 'Бронь успешно создана!']);
} catch (Exception $e) {
    $link->rollback();
    Response::sendBadRequest($e->getMessage());
}