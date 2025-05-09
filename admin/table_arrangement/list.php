<?php

use app\helper\Enum\TableStatusEnum;

session_start();

global $link;
require_once __DIR__ . '/../include/functions.php';

$result = mysqli_query($link, "SELECT t.id as t_id, r.id as r_id, t.table_number, phone, name, date, time_start, time_end, r.capacity as r_capacity, t.capacity as capacity, r.status, comments
FROM reservations as r
         INNER JOIN table_reservations as tb ON tb.reservation_id = r.id
         RIGHT JOIN tables as t ON tb.table_id = t.id AND t.id = tb.table_id
ORDER BY r_id DESC;");

$data = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

?>

<!doctype html>
<html lang="en">
<?php include(__DIR__ . '/../include/head.php'); ?>
<body>
<?php include(__DIR__ . '/../include/header.php'); ?>

<style>
    .grid-stack .restricted-area {
        position: absolute;
        top: 20px; /* Координата Y начала (высота ячейки * строка начала) */
        left: calc(2.1 * 80px); /* Координата X начала (ширина ячейки * колонка начала) */
        width: calc(4.5 * 80px); /* Ширина области */
        height: calc(5.8 * 80px); /* Высота области */
        background-color: rgba(255, 0, 0, 0.2); /* Красный прозрачный фон */
        pointer-events: none;
        z-index: 1;
    }
</style>

<div class="container-fluid h-100">
    <div class="row">
        <?php include(__DIR__ . '/../include/sidebar.php'); ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <?php if (hasPermission('create_post')) { ?>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Бронь</h1>
                    <a class="btn btn-success" href="add.php"> <i class="fa fa-plus"></i> Добавить</a>
                </div>

            <?php } ?>
            <div style="overflow-x: auto;" class="d-flex justify-content-between flex-column flex-xl-row">
                <div class="grid-stack" style="width: 700px; height: 500px;">
                    <div class="restricted-area"></div>
                </div>
                <div>
                    <a id="save-grid" class="btn btn-primary d-none" href="#">Сохранить</a>
                </div>
            </div>
            <div class="table-responsive">
                <table id="table-data" class="table table-striped text-center align-middle" style="width:100%">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Table Number</th>
                        <th>Phone</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Time start</th>
                        <th>Time end</th>
                        <th>Capacity</th>
                        <th>Comments</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $item) { ?>
                        <tr>
                            <td><?= $item['r_id'] ?></td>
                            <td><?= $item['table_number'] ?></td>
                            <td><?= $item['phone'] ?></td>
                            <td><?= $item['name'] ?></td>
                            <td>
                                <?php if (!empty($item['r_id'])) { ?>
                                    <input type="date" value="<?= $item['date'] ?>"
                                           class="form-control date-reservation"
                                           data-reservation-id="<?= $item['r_id'] ?>">
                                <?php } ?>
                            </td>
                            <td>
                                <?php if (!empty($item['r_id'])) { ?>
                                    <select class="form-control time-start" data-value="<?= (new DateTime($item['time_start']))->format('H:i') ?? '' ?>" data-reservation-id="<?= $item['r_id'] ?>"></select>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if (!empty($item['r_id'])) { ?>
                                    <select class="form-control time-end" data-value="<?= (new DateTime($item['time_end']))->format('H:i') ?? ''  ?>" data-reservation-id="<?= $item['r_id'] ?>"></select>
                                <?php } ?>
                            </td>
                            <td><?= $item['r_capacity'] ?></td>
                            <td><?= $item['comments'] ?></td>
                            <td>
                                <?php if (!empty($item['r_id'])) { ?>
                                    <select data-reservation-id="<?= $item['r_id'] ?>"
                                            class="form-select reservationSelect">
                                        <?php foreach (TableStatusEnum::STATUS_LIST as $key => $status) { ?>
                                            <option value="<?= $key ?>" <?= $key == $item['status'] ? 'selected' : '' ?>>
                                                <?= $status ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
<script src="/hiho/node_modules/gridstack/dist/gridstack-all.js"></script>
<link href="/hiho/node_modules/gridstack/dist/gridstack.min.css" rel="stylesheet"/>
<link href="../front/css/gridstack.css" rel="stylesheet"/>
<script type="module" src="../front/js/gridstack/gridstack.js"></script>
<script type="module" src="../front/js/reservation/index.js"></script>
<?php include(__DIR__ . '/../include/scripts.php'); ?>
</body>
</html>

