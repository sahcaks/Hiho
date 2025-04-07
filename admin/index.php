<?php
session_start();
global $link;
require_once __DIR__ . '/include/functions.php';

$users = mysqli_query($link, "SELECT COUNT(*) as `count` FROM user");
$orders = mysqli_query($link, "SELECT COUNT(*) as `count` FROM orders");
$reviews = mysqli_query($link, "SELECT COUNT(*) as `count` FROM reviews");
$dish = mysqli_query($link, "SELECT COUNT(*) as `count` FROM dish");
$menu = mysqli_query($link, "SELECT COUNT(*) as `count` FROM menu");

?>

<!doctype html>
<html lang="en">
<?php include __DIR__ . '/include/head.php'; ?>
<body>

<?php include(__DIR__ . '/include/header.php'); ?>

<div class="container-fluid h-100">
    <div class="row h-100">
        <?php include __DIR__ . '/include/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>
            <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
                <div class="col">
                    <a class="text-decoration-none" href="user/list.php">
                        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg">
                            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                                <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Users</h3>
                                <ul class="d-flex list-unstyled mt-auto">
                                    <li class="me-auto">
                                        <i class="fa fa-user"></i>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <small>Total count: <?= $users->fetch_array()['count'] ?></small>
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
                                <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Orders</h3>
                                <ul class="d-flex list-unstyled mt-auto">
                                    <li class="me-auto">
                                        <i class="fa fa-cart-plus"></i>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <small>Total count: <?= $orders->fetch_array()['count'] ?></small>
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
                                <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Review</h3>
                                <ul class="d-flex list-unstyled mt-auto">
                                    <li class="me-auto">
                                        <i class="fa fa-comment"></i>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <small>Total count: <?= $reviews->fetch_array()['count'] ?></small>
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
                                <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Dish</h3>
                                <ul class="d-flex list-unstyled mt-auto">
                                    <li class="me-auto">
                                        <i class="fa fa-cutlery"></i>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <small>Total count: <?= $dish->fetch_array()['count'] ?></small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a class="text-decoration-none" href="menu/list.php">
                        <div class=" card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg">
                            <div class="d-flex flex-column h-100 p-5 pb-3 text-shadow-1">
                                <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Menu</h3>
                                <ul class="d-flex list-unstyled mt-auto">
                                    <li class="me-auto">
                                        <i class="fa fa-folder-open"></i>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <small>Total count: <?= $menu->fetch_array()['count'] ?></small>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include __DIR__ . '/include/scripts.php'; ?>
</body>
</html>
