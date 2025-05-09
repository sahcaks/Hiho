<?php
global $link;

$reservations = mysqli_query($link, "SELECT COUNT(*) as `count` FROM reservations");
?>
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