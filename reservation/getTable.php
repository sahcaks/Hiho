<?php
session_start();

require_once __DIR__ . "../../database.php";
global $link;
header('Content-Type: application/json');
$result = $link->query("SELECT * FROM tables INNER JOIN table_positions WHERE tables.id = table_positions.table_id");
echo json_encode($result->fetch_all(MYSQLI_ASSOC));
