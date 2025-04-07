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
    <div class="rest">
        <div class="text_about2">
            <h2>О ресторане</h2>
            <p>
                В нашем ресторане мы гордимся своей кухней, предлагая только
                самые свежие ингредиенты и тщательно подготовленные блюда.
                Наша команда опытных шеф-поваров придает блюдам неповторимый вкус,
                чтобы вы могли полностью насладиться грузинской кухней.
            </p>
            <p>
                В нашем ресторане всё происходит в лучших традициях грузинской кухни: самые свежие ингридиенты для блюд,
                атмосфера ресторана отражает культуру Грузии, сохранение уникального вкуса и аромата хинкали,
                передаваемого через поколения, а также взаимодействие
                с нашими гостями со всеми обычаями и особенностями.
            </p>
            <p>
                Мы стремимся создать уютную атмосферу, где вы сможете расслабиться и
                насладиться вкусной едой в компании друзей и семьи. Наш интерьер отражает
                аутентичные грузинские мотивы, чтобы вы могли почувствовать настоящий дух Грузии.
            </p>
        </div>
        <img src="img\restaurant.svg">
    </div>
    <div class="history">
        <img src="img\history.svg">
        <div class="text_about2">
            <h2>Наша история</h2>
            <p>
                История создания ресторана Hinkali House началась с глубокой страсти к грузинской кухне и желания
                привнести аутентичный грузинский вкус
                в наш город.
            </p>
            <p>
                Вдохновленные уникальными ароматами и вкусами Грузии, мы решили создать место, где люди смогут
                насладиться богатством грузинской кухни, особенностями ее культуры и гостеприимством.
            </p>
            <p>
                Наша команда провела многочисленные исследования и путешествия
                по Грузии, изучая традиционные рецепты, секреты и особенности приготовления каждого блюда. Мы стремились
                к тому, чтобы каждая порция, каждый глоток наших блюд, передавал настоящий вкус
                и атмосферу Грузии.
            </p>
            <p>
                Ключевым блюдом нашего меню являются, конечно же, хинкали – изысканные грузинские пельмени, полные
                сочного мяса и неповторимого вкуса. Мы тщательно отбираем свежие и качественные продукты, чтобы каждый
                хинкали, каждое блюдо, приготовленное в Hinkali House, делило
                с гостями яркое и незабываемое впечатление.
            </p>
        </div>
    </div>
    <div class="cooker">
        <div class="block6__text">
            <div class="text6__right">
                <h2>Наши повара</h2>
                <div class="spoiler_block6">
                    <button class="accordion active"
                        onclick="document.getElementById('myImg').src='img/chef1.svg'">Александр Михайлов</button>
                    <div class="panel" style="display: block;">
                        <p>Профессиональный шеф, специализирующийся на хинкали. С его богатым опытом и интуитивным
                            чувством вкуса, он создает блюда, которые удивят ваши вкусовые рецепторы. Александр придает
                            особую важность качеству ингредиентов и деталям приготовления, чтобы каждый хинкали на вашем
                            столе был уникальным и незабываемым.</p>
                    </div>

                    <button class="accordion" onclick="document.getElementById('myImg').src='img/chef2.svg'">Елена
                        Иванова</button>
                    <div class="panel">
                        <p>Опытный повар с более чем 10-летним опытом работы
                            в сфере грузинской кухни. Она привнесет на ваш стол настоящий вкус и аутентичные рецепты
                            хинкали. Коммуникабельная и талантливая, Елена умело сочетает традиционные ингредиенты с
                            современными методами приготовления, чтобы создать идеальные блюда.</p>
                    </div>

                    <button class="accordion" onclick="document.getElementById('myImg').src='img/chef3.svg'">Георгий
                        Петров</button>
                    <div class="panel">
                        <p>Молодой и талантливый повар, мастер хинкали. Он прославился своими смелыми экспериментами и
                            самыми нестандартными комбинациями ингредиентов, которые придают его блюдам неповторимый
                            вкус и аромат. Настоящий кулинарный мастер, который не перестает удивлять своих гостей!</p>
                    </div>

                    <button class="accordion" onclick="document.getElementById('myImg').src='img/chef4.svg'">Владимир
                        Яковлев</button>
                    <div class="panel">
                        <p>Виртуоз в искусстве приготовления хинкали. Его блюда отличаются гармоничным сочетанием
                            традиционного вкуса и современных кулинарных приемов. Владимир обладает необыкновенным
                            талантом в создании блюд, которые не только прекрасно выглядят, но и приносят истинное
                            наслаждение каждому гостю.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="block6_img">
            <div class="decor6_chef"><img id="myImg" src="img/chef1.svg" alt="chef">
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
    <script src="js/index.js"></script>
    <script src="js/swiper-bundle.min.js"></script>
</body>

</html>