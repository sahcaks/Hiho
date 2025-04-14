<?php
session_start();

require_once __DIR__ . "../../database.php";
require_once __DIR__ . "../../helper/helper.php";
global $link;

ensurePostRequest();

$phone = $_POST["phone"];
$name = $_POST["name"];
$date = $_POST["date"];
$time = $_POST["time"];
$capacity = $_POST["capacity"];
$comments = $_POST["comments"];
$tables_id = json_decode($_POST["tables_id"]);

if (!existPhoneNumber($phone)) {
    http_response_code(400);
    echo json_encode(["status" => false, 'description' => 'Телефон не найден, проверьте введенный номер.']);
    exit;
}

$link->begin_transaction();

try {
    $stmt1 = $link->prepare("
        INSERT INTO reservations (phone, name, date, time, capacity, comments) VALUES (?,?,?,?,?,?)
    ");
    $stmt1->bind_param('ssssss', $phone, $name, $date, $time, $capacity, $comments);
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

        $stmt2 = $link->prepare("UPDATE tables SET status = 1 WHERE id = ?");
        $stmt2->bind_param('s', $table_id);
        if (!$stmt2->execute()) {
            throw new Exception('Упс! возникла непредвиденная ошибка, свяжитесь с администратором!');
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

function existPhoneNumber($phone): bool
{
    global $link;

    $query = $link->prepare("SELECT COUNT(phone) as count FROM user WHERE phone = ? LIMIT 1");
    $query->bind_param("i", $phone);
    $query->execute();

    if ($query->get_result()->fetch_row()[0] > 0) {
        return true;
    }
    return false;
}
