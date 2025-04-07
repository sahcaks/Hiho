<?php
include 'database.php';

$sortBy = $_POST['sortBy'];
$sortOrder = $_POST['sortOrder'];
$categoryId = $_POST['categoryId'];

// Запрос на выборку блюд из выбранной категории с сортировкой по цене
$sql = "SELECT * FROM dish WHERE id_category = $categoryId ORDER BY price $sortOrder";
$result = mysqli_query($link, $sql) or die("Ошибка запроса: " . mysqli_error($link));

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='onecard'>";
        echo "<img class='cardimage' src=\"img/dish/" . $row["image"] . "\" alt='Блюдо'>";
        echo "<h2 class='cardname'>" . $row["dish"] . "</h2>";
        echo "<h4>" . $row["weight"] . "</h4>";
        echo "<p class='description'>" . $row["recipes"] . "</p>";
        echo "<div class='infcard'>";
        echo "<p class='price'>" . $row["price"] . ' руб.' . "</p>";

        // Оборачиваем изображение bucket.svg в форму и кнопку
        echo "<form action='add_to_cart.php' method='post' style='display: inline;'>";
        echo "<input type='hidden' name='id_dish' value='" . $row["id_dish"] . "'>";
        echo "<button type='submit' style='background: none; border: none; padding: 0;'>";
        echo "<img class='bucket' src='img/icons/bucket.svg' alt='Добавить в корзину'>";
        echo "</button>";
        echo "</form>";

        echo "</div>"; // Закрываем infcard
        echo "</div>"; // Закрываем onecard
    }
}

$link->close(); // Закрываем соединение с базой
?>