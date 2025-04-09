<?php
session_start();

require_once __DIR__ . "../../database.php";
global $link;
header('Content-Type: application/json');
$result = $link->query("SELECT * FROM tables");
echo json_encode($result->fetch_all(MYSQLI_ASSOC));
