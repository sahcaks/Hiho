<?php
session_start();
unset($_SESSION["name"]);
// возврат пользователя на страницу
header('Location: index.php');
?>