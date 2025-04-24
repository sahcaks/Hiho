<?php
function MENU($this_li)
{
    include 'database.php';

    $menu_sql = "SELECT `name`, `href` FROM `menu`";
    $menu_result = mysqli_query($link, $menu_sql) or die("Ошибка запроса" . mysqli_error($link));

    if ($menu_result) {
        $rows = mysqli_num_rows($menu_result);
        for ($i = 1; $i <= $rows; ++$i) {
            $row = mysqli_fetch_assoc($menu_result);
            echo "<li><a href=\"" . $row['href'] . "\">" . $row['name'] . "</a></li>";
        }
    }
}

function CATEGORIES($cat)
{
    include 'database.php';
    $card_result = mysqli_query($link, $cat) or die("Ошибка запроса" . mysqli_error($link));
    if ($card_result) {
        $rows = mysqli_num_rows($card_result);
        for ($i = 0; $i < $rows; ++$i) {
            $row = mysqli_fetch_assoc($card_result);
            $id = "section" . $row['id_category'];

            echo "<section id='$id'> ";
            echo "<div class='sort-buttons'>";
            echo "<button class='sort-button' data-order='ASC'>По возрастанию цены</button>";
            echo "<button class='sort-button' data-order='DESC'>По убыванию цены</button>";
            echo "</div>";
            echo "<div class='dish_frame' id='dish-frame-" . $row['id_category'] . "'>";
            $qq = "SELECT * FROM dish WHERE id_category =" . $row['id_category'];
            CARDS($qq);
            echo "</div>"; // Закрываем div.dish_frame
            echo "</section>"; // Закрываем section
        }
    }
}

function CARDS($cardsql)
{
    include 'database.php';
    // Определяем кнопку в зависимости от логина пользователя

    // Выполняем запрос
    $card_result = mysqli_query($link, $cardsql) or die("Ошибка запроса " . mysqli_error($link));

    // Проверяем, был ли выполнен запрос
    if ($card_result) {
        $rows = mysqli_num_rows($card_result);

        // Проверяем количество строк результатов
        if ($rows == 0) {
            echo "<p>Нет доступных блюд для отображения.</p>";
            return; // Выйти из функции, если нет данных
        }
        // Перебираем строки результатов
        for ($i = 0; $i < $rows; $i++) {
            $row = mysqli_fetch_assoc($card_result);

            // Проверяем, корректно ли были извлечены данные
            if (!$row) {
                echo "<p>Ошибка при извлечении данных о блюде.</p>";
                continue; // Пропускаем итерацию, если данные недоступны
            }
            $btn = isset($_SESSION['name']) ? "<img data-id='" . $row["id_dish"] . "' class='bucket' src='img/icons/bucket.svg' alt='Добавить в корзину'>" : '';

            // Вывод карточки блюда
            echo "<div class='onecard'>";
            echo "<img class='cardimage' src=\"img/dish/" . htmlspecialchars($row["image"]) . "\" alt='Блюдо'>";
            echo "<h2 class='cardname'>" . htmlspecialchars($row["dish"]) . "</h2>";
            echo "<h4>" . htmlspecialchars($row["weight"]) . "</h4>";
            echo "<p class='description'>" . htmlspecialchars($row["recipes"]) . "</p>";
            echo "<div class='infcard'>";
            echo "<p class='price'>" . htmlspecialchars($row["price"]) . ' руб.' . "</p>";
            echo "<button class='add-to-cart' style='background: none; border: none; padding: 0;'> $btn </button>";
            echo "</div>"; // Закрываем div.infcard
            echo "</div>"; // Закрываем div.onecard
        }
    }
}

function GET_CATEGORIES()
{
    include 'database.php';
    $query = "SELECT * FROM category";
    $result = mysqli_query($link, $query) or die("Ошибка запроса" . mysqli_error($link));

    $categories = array();
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row['name_category'];
        }
    }


    return $categories;
}

?>