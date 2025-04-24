<?php

session_start();

require_once dirname(__DIR__) . '/../config/config.php';
global $link;

$result = $link->query("SELECT * FROM tables INNER JOIN table_positions WHERE tables.id = table_positions.table_id");
echo json_encode($result->fetch_all(MYSQLI_ASSOC));
