<?php
global $link;

$users = mysqli_query($link, "SELECT COUNT(*) as `count` FROM user");
$orders = mysqli_query($link, "SELECT COUNT(*) as `count` FROM orders");
$reviews = mysqli_query($link, "SELECT COUNT(*) as `count` FROM reviews");
$dish = mysqli_query($link, "SELECT COUNT(*) as `count` FROM dish");
$reservations = mysqli_query($link, "SELECT COUNT(*) as `count` FROM reservations");
$category = mysqli_query($link, "SELECT COUNT(*) as `count` FROM category");
$roles = mysqli_query($link, "SELECT COUNT(*) as `count` FROM roles");
?>
<div class="col">
    <a class="text-decoration-none" href="user/list.php">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg">
            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Пользователи</h3>
                <ul class="d-flex list-unstyled mt-auto">
                    <li class="me-auto">
                        <i class="fa fa-user"></i>
                    </li>
                    <li class="d-flex align-items-center">
                        <small>Всего записей: <?= $users->fetch_array()['count'] ?></small>
                    </li>
                </ul>
            </div>
        </div>
    </a>
</div>
<div class="col">
    <a class="text-decoration-none" href="role/list.php">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg">
            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Роли</h3>
                <ul class="d-flex list-unstyled mt-auto">
                    <li class="me-auto">
                        <i class="fa fa-address-book"></i>
                    </li>
                    <li class="d-flex align-items-center">
                        <small>Всего записей: <?= $roles->fetch_array()['count'] ?></small>
                    </li>
                </ul>
            </div>
        </div>
    </a>
</div>

<div class="col">
    <a class="text-decoration-none" href="order/list.php">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg">
            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Заказы</h3>
                <ul class="d-flex list-unstyled mt-auto">
                    <li class="me-auto">
                        <i class="fa fa-cart-plus"></i>
                    </li>
                    <li class="d-flex align-items-center">
                        <small>Всего записей: <?= $orders->fetch_array()['count'] ?></small>
                    </li>
                </ul>
            </div>
        </div>
    </a>
</div>

<div class="col">
    <a class="text-decoration-none" href="review/list.php">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg">
            <div class="d-flex flex-column h-100 p-5 pb-3 text-shadow-1">
                <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Отзывы</h3>
                <ul class="d-flex list-unstyled mt-auto">
                    <li class="me-auto">
                        <i class="fa fa-comment"></i>
                    </li>
                    <li class="d-flex align-items-center">
                        <small>Всего записей: <?= $reviews->fetch_array()['count'] ?></small>
                    </li>
                </ul>
            </div>
        </div>
    </a>
</div>
<div class="col">
    <a class="text-decoration-none" href="dish/list.php">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg">
            <div class="d-flex flex-column h-100 p-5 pb-3 text-shadow-1">
                <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Блюда</h3>
                <ul class="d-flex list-unstyled mt-auto">
                    <li class="me-auto">
                        <i class="fa fa-cutlery"></i>
                    </li>
                    <li class="d-flex align-items-center">
                        <small>Всего записей: <?= $dish->fetch_array()['count'] ?></small>
                    </li>
                </ul>
            </div>
        </div>
    </a>
</div>
<div class="col">
    <a class="text-decoration-none" href="category/list.php">
        <div class=" card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg">
            <div class="d-flex flex-column h-100 p-5 pb-3 text-shadow-1">
                <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Категории</h3>
                <ul class="d-flex list-unstyled mt-auto">
                    <li class="me-auto">
                        <i class="fa fa-cubes"></i>
                    </li>
                    <li class="d-flex align-items-center">
                        <small>Всего записей: <?= $category->fetch_array()['count'] ?></small>
                    </li>
                </ul>
            </div>
        </div>
    </a>
</div>
<div class="col">
    <a class="text-decoration-none" href="table_arrangement/list.php">
        <div class=" card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg">
            <div class="d-flex flex-column h-100 p-5 pb-3 text-shadow-1">
                <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Бронь</h3>
                <ul class="d-flex list-unstyled mt-auto">
                    <li class="me-auto">
                        <i class="fa fa-th-large"></i>
                    </li>
                    <li class="d-flex align-items-center">
                        <small>Всего записей: <?= $reservations->fetch_array()['count'] ?></small>
                    </li>
                </ul>
            </div>
        </div>
    </a>
</div>