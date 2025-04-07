<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hinkali House</title>
    <?php include "shared_styles.php"; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poiret+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Philosopher:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/swiper-bundle.min.css">
    <style>
        .disabled {
            pointer-events: none;
            opacity: 0.5;
        }

        /* Отключение прокрутки страницы */
        .modal-open {
            overflow: hidden;
        }

        .modal_rew {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .modal-content {

            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
            border-radius: 5px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .rating-container {
            display: flex;
            gap: 10px;
        }

        .rating-img {
            width: 50px;
            cursor: pointer;
        }

        .rating-input {
            display: none;
        }

        .rating-input:checked+label img {
            border: 2px solid #f1c40f;
        }

        .rew-head {
            display: flex;
            width: 95%;
            justify-content: space-between;
            align-items: center;
        }

        .rew-bot {
            display: flex;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    $isLoggedIn = isset($_SESSION['name']);

    if ($isLoggedIn) {
        $username = $_SESSION['name'];
    }
    ?>

    <?php include 'header.php'; ?>
    <?php include 'modal_forms.php'; ?>
    <div id="reviewModal" class="modal_rew">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Ваш отзыв</h2>
            <form id="modal-review-form" action="submit_review.php" method="post">
                <textarea id="content" name="content" required></textarea><br>

                <p>Оцените заведение от 1 до 5:</p><br>
                <div class="rating-container">
                    <input type="radio" id="rating1" name="rating" value="1" class="rating-input"><label
                        for="rating1"><img src="img/icons/hinkal.ico" alt="1" class="rating-img">
                        <p style="text-align: center">1</p>
                    </label>
                    <input type="radio" id="rating2" name="rating" value="2" class="rating-input"><label
                        for="rating2"><img src="img/icons/hinkal.ico" alt="2" class="rating-img">
                        <p style="text-align: center">2</p>
                    </label>
                    <input type="radio" id="rating3" name="rating" value="3" class="rating-input"><label
                        for="rating3"><img src="img/icons/hinkal.ico" alt="3" class="rating-img">
                        <p style="text-align: center">3</p>
                    </label>
                    <input type="radio" id="rating4" name="rating" value="4" class="rating-input"><label
                        for="rating4"><img src="img/icons/hinkal.ico" alt="4" class="rating-img">
                        <p style="text-align: center">4</p>
                    </label>
                    <input type="radio" id="rating5" name="rating" value="5" class="rating-input"><label
                        for="rating5"><img src="img/icons/hinkal.ico" alt="5" class="rating-img">
                        <p style="text-align: center">5</p>
                    </label>
                </div><br>

                <?php if ($isLoggedIn): ?>
                    <!-- Скрытое поле для передачи имени пользователя -->
                    <input type="hidden" name="username" value="<?php echo $username; ?>">
                <?php endif; ?>

                <?php if ($isLoggedIn): ?>
                    <button type="submit" class="submit-button">Отправить отзыв</button>
                <?php else: ?>
                    <button type="submit" class="submit-button disabled" disabled>Отправить отзыв</button>
                    <p>Пожалуйста, авторизуйтесь.</p>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="slider_div">
        <div class="rew-head">
            <h2 class="sl_h">Клиенты о Hinkali House</h2>
            <!-- Кнопка для открытия модального окна -->
            <button id="openReviewModal" class="submit-button">Отправить отзыв</button>
        </div>
        <div class="sl_slider"><?php include 'slider.php'; ?></div>
    </div>
    <div>
        <h2 class="sl_h">Оцените наше заведение</h2>
        <div class="rew_about">
            <div class="rew_text">
                <p class="rew_tx">
                    С целью повышения качества обслуживания мы предоставляем каждому клиенту нашего заведения
                    возможность оставить отзыв.<br>
                    <br>
                    Для нас важно мнение наших клиентов и мы с радостью учтём все комментарии и предложения!
                </p>
                <img src="img/review.svg">
            </div>
        </div>
    </div>

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
            <div class="socials"><img src="img/icons/inst.svg"> <img src="img/icons/facebook.svg"><img
                    src="img/icons/tg.svg"></div>
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
    <script src="js/modal.js"></script>
    <script src="js/index.js"></script>
    <script src="js/swiper-bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            // Открытие модального окна
            $('#openReviewModal').click(function () {
                $('#reviewModal').css('display', 'block');
                $('body').addClass('modal-open'); // Добавляем класс для отключения прокрутки
            });

            // Закрытие модального окна
            $('.close').click(function () {
                $('#reviewModal').css('display', 'none');
                $('body').removeClass('modal-open'); // Убираем класс для включения прокрутки
            });

            // Закрытие модального окна при клике вне его
            $(window).click(function (event) {
                if ($(event.target).is('#reviewModal')) {
                    $('#reviewModal').css('display', 'none');
                    $('body').removeClass('modal-open'); // Убираем класс для включения прокрутки
                }
            });

            // Обработка отправки формы в модальном окне
            $('#modal-review-form').submit(function (e) {
                e.preventDefault(); // Предотвращаем стандартную отправку формы

                var form = $(this);
                var url = form.attr('action'); // Получаем URL для отправки формы
                var formData = form.serialize(); // Сериализуем поля формы

                // Отправка AJAX-запроса
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    success: function (response) {
                        alert('Благодарим за ваш отзыв.');

                        // Очистка полей формы
                        form.trigger('reset');

                        // Закрытие модального окна
                        $('#reviewModal').css('display', 'none');
                    },
                    error: function () {
                        alert('Произошла ошибка. Пожалуйста, попробуйте еще раз.');
                    }
                });
            });
        });
    </script>
</body>

</html>