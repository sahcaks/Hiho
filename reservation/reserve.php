<?php

use app\helper\Enum\TableStatusEnum;

session_start();

require_once dirname(__DIR__) . "/config/config.php";
global $link;

ensurePostRequest();

$phone = $_POST["phone"];
$name = $_POST["name"];
$date = $_POST["date"];
$time_start = (new DateTime($_POST["time_start"]))->format('H:i:s') ?? null;
$time_end = (new DateTime($_POST["time_end"]))->format('H:i:s') ?? null;
$capacity = $_POST["capacity"];
$comments = $_POST["comments"];
$tables_id = json_decode($_POST["tables_id"]);
$user_id = $_SESSION["id_user"] ?? null;
$status = TableStatusEnum::PENDING;

$link->begin_transaction();

try {
    $stmt1 = $link->prepare("
        INSERT INTO reservations (phone, name, date, time_start, time_end, capacity, comments, status, user_id) VALUES (?,?,?,?,?,?,?,?,?)
    ");
    $stmt1->bind_param('sssssssss', $phone, $name, $date, $time_start, $time_end, $capacity, $comments, $status, $user_id);
    if (!$stmt1->execute()) {
        throw new Exception('Упс! возникла непредвиденная ошибка, свяжитесь с администратором!');
    }
    $reservation_id = $stmt1->insert_id;
    if (empty($reservation_id)) {
        throw new Exception('Упс! возникла непредвиденная ошибка, свяжитесь с администратором!');
    }
    foreach ($tables_id as $table_id) {
        $query = $link->prepare("INSERT INTO table_reservations (table_id, reservation_id) VALUES (?,?)");
        $query->bind_param('ss', $table_id, $reservation_id);
        if (!$query->execute()) {
            throw new Exception("Error executing query 1: " . $query->error);
        }
    }

    $link->commit();

    http_response_code(200);
    echo json_encode(["status" => true]);

} catch (Exception $e) {
    $link->rollback();
    http_response_code(400);
    echo json_encode(["status" => false, 'description' => $e->getMessage()]);
}
