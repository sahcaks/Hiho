<?php
include 'functions.php';
include 'database.php';

// Проверка, установлен ли идентификатор сессии
session_start();

// Получаем данные из POST-запроса
$category = $_POST['category'] ?? null; // Используем null, если параметр не задан
$searchTerm = $_POST['searchTerm'] ?? '';

// Проверка на наличие категории и поиска
if ($category && $searchTerm) {
    // Подготовка SQL-запроса с параметрами
    $category = mysqli_real_escape_string($link, $category);
    $searchTerm = mysqli_real_escape_string($link, $searchTerm);

    // Формируем SQL-запрос
    $cardsql = "SELECT * FROM dish 
                 WHERE id_category = (SELECT id_category FROM category WHERE name_category = '$category') 
                 AND dish LIKE '%$searchTerm%'";

    // Выполняем запрос к базе данных
    $card_result = mysqli_query($link, $cardsql) or die("Ошибка запроса: " . mysqli_error($link));

    // Проверяем, были ли найдены результаты
    if ($card_result && mysqli_num_rows($card_result) > 0) {
        // Выводим карточки найденных блюд
        while ($row = mysqli_fetch_assoc($card_result)) {
            echo "<div class='onecard'>";
            echo "<img class='cardimage' src=\"img/dish/" . htmlspecialchars($row["image"]) . "\" alt='Блюдо'>";
            echo "<h2 class='cardname'>" . htmlspecialchars($row["dish"]) . "</h2>";
            echo "<h4>" . htmlspecialchars($row["weight"]) . "</h4>";
            echo "<p class='description'>" . htmlspecialchars($row["recipes"]) . "</p>";
            echo "<div class='infcard'>";
            echo "<p class='price'>" . htmlspecialchars($row["price"]) . " руб.</p>";
            // Проверяем авторизацию пользователя для отображения кнопки добавления в корзину
            if (isset($_SESSION['name'])) {
                echo "<form action='add_to_cart.php' method='post' style='display: inline;'>";
                echo "<input type='hidden' name='id_dish' value='" . htmlspecialchars($row["id_dish"]) . "'>";
                echo "<button type='submit' style='background: none; border: none; padding: 0;'>";
                echo "<img class='bucket' src='img/icons/bucket.svg' alt='Добавить в корзину'>  ";
                echo "</button>";
                echo "</form>";
            }
            echo "</div>"; // Закрытие .infcard
            echo "</div>"; // Закрытие .onecard
        }
    } else {
        // Если нет найденных блюд, выводим сообщение
        echo "<p>Таких товаров не найдено.</p>";
    }

}
?>