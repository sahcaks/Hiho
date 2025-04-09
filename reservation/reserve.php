<?php
session_start();

require_once __DIR__ . "../../database.php";
require_once __DIR__ . "../../helper/helper.php";
global $link;

$phone = $_POST["phone"];
$name = $_POST["name"];
$date = $_POST["date"];
$time = $_POST["time"];
$person_count = $_POST["person_count"];
$comments = $_POST["comments"];
$tables_id = json_decode($_POST["tables_id"]);

$query = $link->prepare("
        INSERT INTO reservations (phone, name, date, time, person_count, comments) VALUES (?,?,?,?,?,?)
    ");
$query->bind_param('ssssss', $phone, $name, $date, $time, $person_count, $comments);
$query->execute();

$reservation_id = $query->insert_id;
if (!empty($reservation_id)) {
    foreach ($tables_id as $table_id) {
        $query = $link->prepare("INSERT INTO table_reservations (table_id, reservation_id) VALUES (?,?)");
        $query->bind_param('ii', $table_id, $reservation_id);
        $query->execute();
    }
}

if ($query->get_result()->num_rows > 0) {
    echo json_encode(["status" => true]);
} else {
    echo json_encode(["status" => false]);
}
