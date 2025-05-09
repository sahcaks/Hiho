<?php

use app\helper\Enum\TableStatusEnum;

session_start();

require_once dirname(__DIR__) . "/config/config.php";
global $link;
header('Content-Type: application/json');

$time_start = (new DateTime($_POST["time_start"]))->format('H:i:s');
$time_end = (new DateTime($_POST["time_end"]))->format('H:i:s');
$date = !empty($_POST["date"]) ? (new DateTime($_POST['date']))->format('Y-m-d') : date("Y-m-d");

$stmt = $link->prepare("SELECT r.time_start, r.time_end, r.date, r.status, tp.* FROM reservations as r
    INNER JOIN table_reservations as tr
    RIGHT JOIN tables as t ON tr.table_id = t.id AND tr.reservation_id = r.id
    LEFT JOIN table_positions as tp ON t.id = tp.table_id");

$stmt->execute();
$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

foreach ($result as $item) {
    if (!empty($item['date']) && $item['date'] !== $date) {
        $item['status'] = TableStatusEnum::OPEN;
    }

    if ($item['date'] == $date && ($time_start > $item['time_start'] && $time_end > $item['time_end']) || ($time_start <= $item['time_end'] && $time_end <= $item['time_start'])) {
        $item['status'] = TableStatusEnum::OPEN;
    }

    if (isset($data[$item['table_id']]) && $data[$item['table_id']]['date'] === $date) {
        continue;
    }

    $data[$item['table_id']] = $item;
}

$data = array_values($data);
echo json_encode($data);
