<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hinkali House</title>
    <?php
    include "shared_styles.php";
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poiret+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Philosopher:ital,wght@0,400;0,700;1,400;1,700&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="css/swiper-bundle.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
</head>

<body>
<?php
include 'header.php';
?>
<?php include 'modal_forms.php'; ?>

<form id="search-form">
    <h2>Найдите желаемое блюдо!</h2>
    <div class="search_but">
        <input type="text" name="search" placeholder="Название блюда">
        <input type="submit" value="Найти">
    </div>
    <div class="menu-categ">
        <div class="category-block">
            <?php
            $categories = GET_CATEGORIES();
            foreach ($categories as $category) {
                // Устанавливаем путь к изображению для каждой категории
                $imagePath = "img/icons/$category.png"; // Замените на правильный путь к изображениям
                $checked = ($category === 'Основное меню') ? 'checked' : '';

                echo "
                    <div class='category-item'>
                        <label for='$category' class='categ_radio'>
                            <img src='$imagePath' alt='$category' class='category-image'>
                            <p>$category</p>
                        </label>
                        <input type='radio' name='category' value='$category' id='$category' style='display:none;' $checked>
                    </div>
                ";
            }
            ?>
        </div>
        <div class="radio_search">
            <div id="search-results"></div>
            <div class="menu-container" id="main-menu">
                <?php
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
            </div>
        </div>
    </div>


</form>


<footer>
    <div class="previev">
        <h3>Мы рядом с вами!</h3>
        <h3>г. Минск, ул. Белорусская, 21</h3>
    </div>
    <div class="previev">
        <h3>Забронируйте столик</h3>
        <h3>+375259592122</h3>
        <h3>Время работы с 9:00 до 21:00</h3>
    </div>
    <div class="previev2">
        <h3>Мы в социальных сетях</h3>
        <div class="socials">
            <img src="img/icons/inst.svg">
            <img src="img/icons/facebook.svg">
            <img src="img/icons/tg.svg">
        </div>
    </div>
    <div class="confid">
        <div class="nav">
            <h3>Меню</h3>
            <h3>О нас</h3>
            <h3>Отзывы</h3>
        </div>
        <img class="logo_foot" src="img/icons/logo.svg">
        <h3>2023 © Hinkali House | khinkalihouse.by️</h3>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="js/modal.js"></script>
<script src="js/swiper-bundle.min.js"></script>
<script src="js/index.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Обработчик изменения радиокнопок
        document.querySelectorAll('input[name="category"]').forEach(item => {
            item.addEventListener('change', function () {
                const selectedCategory = this.value;

                // Запрос для загрузки содержимого категории
                fetch('load_category.php?category=' + encodeURIComponent(selectedCategory))
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('main-menu').innerHTML = data; // Обновляем меню
                        attachSortButtonHandlers(); // Присоединяем обработчики для кнопок сортировки
                    })
                    .catch(error => console.error('Ошибка:', error));

                // Сброс данных поиска
                document.querySelector('input[name="search"]').value = ''; // Очистка поля поиска
                document.getElementById('search-results').innerHTML = ''; // Сброс результатов поиска
                $('#main-menu').show(); // Показываем основное меню
            });
        });

        // Обработка отправки формы поиска
        document.getElementById('search-form').addEventListener('submit', function (e) {
            e.preventDefault();
            searchDishes();
        });

        // Начальное прикрепление обработчиков к кнопкам сортировки для категории по умолчанию
        attachSortButtonHandlers();
    });

    // Функция для поиска блюд
    function searchDishes() {
        var category = $('input[name="category"]:checked').val();
        var searchTerm = $('input[name="search"]').val();

        $.ajax({
            url: 'search.php',
            method: 'POST',
            data: {category: category, searchTerm: searchTerm},
            success: function (response) {
                $('#search-results').html(response);
                // Если в результатах есть блюда, скрываем основное меню
                if ($('#search-results .onecard').length > 0) {
                    $('#main-menu').hide(); // Скрываем основное меню
                } else {
                    $('#main-menu').show(); // Показываем основное меню, если ничего не найдено
                }
                loadEventToAddCart();
            }
        });
    }

    // Обработчик для кнопок сортировки
    function attachSortButtonHandlers() {
        document.querySelectorAll('.sort-button').forEach(button => {
            button.addEventListener('click', function () {
                var order = this.dataset.order; // Получаем порядок сортировки
                var categoryId = this.closest('section').id.replace('section', ''); // Получаем ID категории
                sortDishes(categoryId, order); // Запускаем сортировку
            });
        });
    }

    // Функция для сортировки
    function sortDishes(categoryId, order) {
        $.ajax({
            url: 'sort_handler.php',
            method: 'POST',
            data: {
                sortBy: 'price', // Поле сортировки
                sortOrder: order, // Порядок сортировки
                categoryId: categoryId // ID категории
            },
            success: function (response) {
                $('#dish-frame-' + categoryId).html(response); // Обновляем блюда внутри секции
            },
            error: function (xhr, status, error) {
                console.error('Ошибка:', error);
            }
        });
    }

    function loadEventToAddCart() {
        let carts = document.querySelectorAll('button.add-to-cart');
        if (carts.length > 0) {
            Array.prototype.slice.call(carts).forEach(function (cart) {
                cart.removeEventListener('click', handleAddToCart);
                cart.addEventListener('click', handleAddToCart);
            });
        }
    }

    async function handleAddToCart(event) {
        const MAIN_URL = location.protocol + "//" + location.host + "/hiho/";
        const element = event.currentTarget;
        let data = new FormData();
        data.append('id_dish', element.children[0].dataset.id);
        await fetch(MAIN_URL + '/add_to_cart.php', {
            method: 'POST',
            body: data
        })
            .then(async response => {
                const result = await response.json();
                if (result.status) {
                    toastr.success('Блюдо добавлено!');
                    document.getElementById('cart-count').innerHTML = result.total;
                }
            })
            .catch(error => toastr.error('Ошибка при добавлении в корзину:', error));
    }

    loadEventToAddCart();
</script>
</body>

</html>