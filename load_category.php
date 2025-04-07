<?php
session_start();
include 'functions.php';

if (isset($_GET['category'])) {
    $category_name = $_GET['category'];
    $cat = "SELECT * FROM category WHERE name_category = '$category_name'";
    CATEGORIES($cat);
} else {
    // Отображение категории по умолчанию
    $cat = "SELECT * FROM category WHERE name_category = 'Основное меню'";
    CATEGORIES($cat);
}
?>