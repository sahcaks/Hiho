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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
<div class="pop_up" id="pop_up">
    <div class="pop_up_container">
        <div class="pop_up_body" id="pop_up_body">
            <form>
                <input type="text" placeholder="Name">
                <input type="text" placeholder="Phone">
                <input type="reset" class="button" value="Contact">
            </form>
            <div class="pop_up_close" id="pop_up_close">&#10006;</div>
        </div>
    </div>
</div>
<header>
    <div class="container">
        <nav class="container header__nav-center">
            <button class="burger" onclick="openNav()"><img src="img/icons/burger.png" alt="burger-menu"></button>
            <a class="logo_head" href="index.php">
                <img src="img\icons\logo.svg" alt="logo">
            </a>
            <ul>
                <?php
                include 'functions.php';
                MENU('');
                ?>
            </ul>
            <?php
            if (isset($_SESSION['name'])) {
                echo "<div class='head_icon cart-icon'>";
                echo "<a href='admin/'><span style='font-size: 25px' class='fa fa-user'></span></a>";
                echo "<a href=\"cart.php\"><img src='img\icons\bucket1.svg' alt='bucket' class='bucket basket-icon'></a>";
                echo "<span class='cart-count' id='cart-count'>" . count($_SESSION['cart']) . "</span>";
                echo "<a href=\"logout.php\" class=\"exit\" id=\"logout\">Выйти</a>";
                echo "</div>";
            } else
                echo "<button class=\"login\" id=\"login\">Войти</button>";
            ?>
        </nav>
        <div id="myNav" class="overlay">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <div class="overlay-content">
                <ul>
                    <?php
                    if (function_exists('MENU')) {
                        MENU('');
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</header>
<script src="js/index.js"></script>
</body>