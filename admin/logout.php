<?php
require_once __DIR__ . '/../helper/helper.php';

const HOME_URL = "http://localhost:8888/hiho/";

session_start();
unset($_SESSION['name']);
setcookie('rememberme', '', 0, '/');
redirect(HOME_URL);