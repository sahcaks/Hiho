<?php
session_start();
?>
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
</head>

<body>
    <?php
    include 'header.php'
        ?>
    <?php include 'modal_forms.php'; ?>
    <div class="baner">
        <div>
            <h1>Hinkali House</h1>
            <a href="reservation.php" class="more">Подробнее</a>
            <form action="menu.php" target="_blank">
                <button class="more">К меню</button>
            </form>
        </div>
        <img src="img/dishes.svg">
    </div>
    <div class="about">
        <div class="text_about">
            <h2>О ресторане</h2>
            <p>
                В нашем ресторане мы гордимся своей кухней, предлагая только
                самые свежие ингредиенты и тщательно подготовленные блюда.
                Наша команда опытных шеф-поваров придает блюдам неповторимый вкус,
                чтобы вы могли полностью насладиться грузинской кухней.
            </p>
            <p>
                Мы стремимся создать уютную атмосферу, где вы сможете расслабиться и
                насладиться вкусной едой в компании друзей и семьи. Наш интерьер отражает
                аутентичные грузинские мотивы, чтобы вы могли почувствовать настоящий дух Грузии.
            </p>
            <form action="about.php" target="_blank">
                <button class="more">Подробнее</button>
            </form>
        </div>
        <img src="img/restaurant.svg">
    </div>
    <div class="anatomy">
        <h2>Анатомия хинкали</h2>
        <img src="img/anatomy.svg">
    </div>
    <div class="menu_num">
        <h2>Вкусно как дома</h2>
        <div class="menu">
            <a href="menu.php"><img src="img/menu1.svg"></a>
            <a href="menu.php"><img src="img/menu2.svg"></a>
            <a href="menu.php"><img src="img/menu3.svg"></a>
        </div>
    </div>
    <div class="reviews">
        <section id="review" class="review s-block">
            <div class="container_rew">
                <div class="block3__text">
                    <h2>Акции и предложения</h2>
                </div>
                <div class="review__inner">
                    <div id="review-slider-js" class="swiper review__slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="review__item">
                                    <img src="img/card1.svg">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="review__item">
                                    <img src="img/card2.svg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="review__item">
                                    <img src="img/card3.svg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="review__item">
                                    <img src="img/card4.svg">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </section>
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
            <div class="socials"><img src="img\icons\inst.svg"> <img src="img\icons\facebook.svg"><img
                    src="img\icons\tg.svg"></div>
        </div>
        <div class="confid">
            <div class="nav">
                <a href="calories.rar" download>Рассчитай калории на день!</a>
            </div>
            <img class="logo_foot" src="img\icons\logo.svg">
            <h3>2023 © Hilkali House | khinkalihouse.by️</h3>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/swiper-bundle.min.js"></script>
    <script src="js/index.js"></script>
</body>
</html>