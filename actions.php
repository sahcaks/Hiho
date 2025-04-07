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
</head>

<body>
    <?php
    include 'header.php'
        ?>
    <?php include 'modal_forms.php'; ?>
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
                                    <img src="img\card1.svg">
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="review__item">
                                    <img src="img\card2.svg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="review__item">
                                    <img src="img\card3.svg">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="review__item">
                                    <img src="img\card4.svg">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="action1">
        <div class="text_about2">
            <h2>2 по цене 1</h2>
            <p>
                Акция «2 по цене 1» - незабываемая возможность каждый четверг насладиться нашими вкуснейшими хинкали по
                выгодной цене!
            </p>
            <p>
                При заказе двух порций хинкали вы оплачиваете только за одну. Разнообразные начинки, тонкое тесто и
                неповторимый вкус - все это ждет вас
                в нашем ресторане.
            </p>
            <p>
                Проведите время с друзьями или семьей, наслаждаясь неповторимым ароматом и вкусом горячих хинкали.
                Акционная
                программа доступна как для посетителей ресторана, так и для заказа с доставкой.
            </p>
            <p>
                Поторопитесь скорее воспользоваться нашей акцией, ведь ничто не сравнится
                с удовольствием от вкусных и выгодных хинкали!
            </p>
        </div>
        <img src="img\action1.svg">
    </div>
    <div class="action2">
        <img src="img\action2.svg">
        <div class="text_about2">
            <h2>Семейный ужин</h2>
            <p>
                Приглашаем вас на нашу акцию «Семейный ужин» в ресторане хинкали! Насладитесь атмосферой тепла и уюта,
                наслаждаясь великолепным выбором вкусных блюд для всей семьи.
            </p>
            <p>
                Вас ждет специальное предложение, которое включает в себя разнообразные виды хинкали, соусы и
                дополнительные гарниры со скидкой 30%.
            </p>
            <p>
                Проведите замечательное время вместе с в нашем ресторане и насладитесь вкусом настоящей Грузии.
            </p>
            <p>
                Не упустите шанс попробовать наши семейные комбинации вкуснейших блюд по привлекательной цене. Ждем вас
                и вашу семью в нашем ресторане хинкали!
            </p>
        </div>
    </div>
    <div class="action1">
        <div class="text_about2">
            <h2>День хинкали</h2>
            <p>
                Приглашаем всех любителей ароматного и сочного хинкали на нашу акцию «День хинкали»! Каждый понедельник
                вы сможете насладиться непревзойденным вкусом наших блюд со скидкой 20%, распространяющейся на весь чек.
            </p>
            <p>
                Мы предлагаем вам разнообразные варианты хинкали: от классических мясных до оригинальных вегетарианских.
                Насладитесь сочным мясом, нежными специями и идеально приготовленным тестом.
            </p>
            <p>
                Приходите в наш ресторан хинкали и отведайте наши замечательные блюда
                по специальной цене в этот «День хинкали»!
            </p>
        </div>
        <img src="img\action3.svg">
    </div>
    <div class="action2">
        <img src="img\action4.svg">
        <div class="text_about2">
            <h2>Ланч бокс</h2>
            <p>
                Акция «Ланч Бокс» - идеальное решение для тех, кто хочет насладиться вкусным и сытным обедом на вынос.
            </p>
            <p>
                Предлагаем вам собрать свой собственный ланч, выбрав из нашего меню хинкали. Создайте свой идеальный
                комплект, выбрав ваш любимый вид начинки и соуса.
            </p>
            <p>
                Мы гарантируем свежесть и качество каждого блюда. Получите свой «Ланч Бокс» за выгодную цену и
                насладитесь аутентичным вкусом хинкали в любое удобное время. Каждый понедельник на акцию «Ланч Бокс»
                дейтсвует скидка 20%.
            </p>
            <p>
                Поторопитесь воспользоваться нашей акцией и порадуйте себя и своих близких вкусным обедом!
            </p>
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
            <h3>2023 © Hilkali House | khinkalihouse.by️</h3>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/swiper-bundle.min.js"></script>
    <script src="js/index.js"></script>
</body>