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
    <script src="https://api-maps.yandex.ru/2.1/?apikey=1a612f5d-96d1-43d2-adef-8c73649fe8ea&lang=ru_RU"
        type="text/javascript"></script>
</head>

<body>
    <?php
    include 'header.php'
        ?>
    <?php include 'modal_forms.php'; ?>
    <div class="location">
        <h2>Где мы находимся?</h2>
        <div class="map">
            <div id="map" class="map_ya"></div>
            <div class="adress">
                <div class="ad1">
                    <h2><img src="img/icons/geo.svg">г. Минск, пер. Дубравинский, 5</h2>
                </div>
                <div class="ad2">
                    <h2><img src="img/icons/phone.svg"> +375259592122</h2>
                </div>
                <div class="ad3">
                    <h2><img src="img/icons/gmail.svg"> hinkali.house@gmail.com</h2>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="previev">
            <h3>Мы рядом с вами!</h3>
            <h3>г. Минск, пер. Дубравинский, 5</h3>
        </div>
        <div class="previev">
            <h3>Забронируйте столик</h3>
            <h3>+375259592122</h3>
            <h3>Время работы с 9:00 до 21:00</h3>
        </div>
        <div class="previev2">
            <h3>Мы в социальных сетях</h3>
            <div class="socials"><img src="img\icons\inst.svg"> <img src="img\icons\facebook.svg"><img
                    src="img\icons\tg.svg"></div>
        </div>
        <div class="confid">
            <div class="nav">
                <h3>Меню</h3>
                <h3>О нас</h3>
                <h3>Отзывы</h3>
            </div>
            <img class="logo_foot" src="img\icons\logo.svg">
            <h3>2025 © Hilkali House | khinkalihouse.by️</h3>
        </div>
    </footer>
    <script>
        ymaps.ready(function () {
            var myMap = new ymaps.Map("map", {
                center: [53.877731, 27.506459],
                zoom: 14,
            });

            var myPlacemark = new ymaps.Placemark(
                [53.877731, 27.506459],
                {
                    hintContent: "HiHo",
                    balloonContent: "<strong>HiHo</strong><br>Адрес: пер. Дубравинский, 5",
                },
                {
                    iconLayout: "default#image",
                    iconImageHref: "../img/icons/gps.png",
                    iconImageSize: [42, 42],
                    iconImageOffset: [-21, -42],
                    hideIconOnBalloonOpen: false,
                }
            );

            myMap.geoObjects.add(myPlacemark);
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/index.js"></script>
    <script src="js/swiper-bundle.min.js"></script>

</body>

</html>