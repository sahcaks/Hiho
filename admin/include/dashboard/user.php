<?php
global $link;
$id = $_SESSION['id_user'];
$orders = mysqli_query($link, "SELECT COUNT(*) as `count` FROM orders");
$stmt = $link->prepare("SELECT COUNT(*) as `count` FROM reservations WHERE user_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$table_arrangement = $stmt->get_result();

?>
<div class="col">
    <a class="text-decoration-none" href="user/profile/list.php">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg">
            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Профиль</h3>
                <ul class="d-flex list-unstyled mt-auto">
                    <li class="me-auto">
                        <i class="fa fa-user"></i>
                    </li>
                </ul>
            </div>
        </div>
    </a>
</div>

<div class="col">
    <a class="text-decoration-none" href="order/history.php">
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
    <a class="text-decoration-none" href="user/reservations/list.php">
        <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg">
            <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">Мои бронирования</h3>
                <ul class="d-flex list-unstyled mt-auto">
                    <li class="me-auto">
                        <i class="fa fa-th-large"></i>
                    </li>
                    <li class="d-flex align-items-center">
                        <small>Всего записей: <?= $table_arrangement->fetch_array()['count'] ?></small>
                    </li>
                </ul>
            </div>
        </div>
    </a>
</div>