<?php
session_start();
require_once __DIR__ . '/config/config.php'
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
    <link href="<?= WEB_FRONT_URL ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<?php
include 'header.php'
?>
<main>
    <div class="container-fluid">
        <div class="d-flex justify-content-around flex-xxl-row flex-column">
            <form method="post" class="col-12 col-xxl-6 row g-3 p-4">
                <div class="col-md-6">
                    <label for="phone" class="form-label">Телефон</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="123456789">
                </div>
                <div class="col-md-6">
                    <label for="name" class="form-label">Имя</label>
                    <input type="text" class="form-control" id="name" name="name" value="Test">
                </div>
                <div class="col-md-6">
                    <label for="date" class="form-label">Дата</label>
                    <input type="date" class="form-control" id="date" name="date" value="2025-04-10">
                </div>
                <div class="col-md-6">
                    <label for="time" class="form-label">Время</label>
                    <input type="time" class="form-control" id="time" name="time" value="10:00">
                </div>
                <div class="col-12">
                    <label for="person_count" class="form-label">Количество человек</label>
                    <select id="person_count" name="person_count" class="form-select">
                        <option>1</option>
                        <option>2</option>
                        <option selected>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="comments" class="form-label">Comments</label>
                    <textarea class="form-control" id="comments" rows="3" name="comments"></textarea>
                </div>
                <div class="col-12 d-flex justify-content-end align-items-center">
                    <button type="submit" class="btn btn-primary">Забронировать</button>
                </div>
            </form>
            <div style="overflow-x: auto;">
                <div class="grid-stack" style="width: 900px;"></div>
            </div>
        </div>
    </div>
</main>
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
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/modal.js"></script>
<script src="js/swiper-bundle.min.js"></script>
<script src="js/index.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="/hiho/node_modules/gridstack/dist/gridstack-all.js"></script>
<link href="/hiho/node_modules/gridstack/dist/gridstack.min.css" rel="stylesheet"/>
<link href="css/gridstack.css" rel="stylesheet"/>
<script src="js/gridstack/gridstack.js"></script>
</html>