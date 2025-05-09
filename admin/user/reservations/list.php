<?php

use app\helper\Enum\TableStatusEnum;

session_start();

global $link;
require_once dirname(__DIR__) . '/../include/functions.php';

$id = $_SESSION['id_user'];

$stmt = $link->prepare('SELECT *, t.table_number FROM reservations as r INNER JOIN  table_reservations as tr ON r.id = tr.reservation_id INNER JOIN  tables as t ON t.id = tr.table_id WHERE user_id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

function getStatusBadge(int $status): string
{
    if (TableStatusEnum::PENDING === $status) {
        return '<span class="badge text-bg-warning">Pending</span>';
    }
    return '<span class="badge text-bg-success">Reserved</span>';
}

?>

<!doctype html>
<html lang="en">
<?php include(dirname(__DIR__) . '/../include/head.php'); ?>
<body>
<?php include(dirname(__DIR__) . '/../include/header.php'); ?>
<div class="container-fluid h-100">
    <div class="row">
        <?php include(dirname(__DIR__) . '/../include/sidebar.php'); ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Мои бронирования</h1>
            </div>
            <div class="table-responsive">
                <table id="table-data" class="table table-striped text-center align-middle" style="width:100%">
                    <thead>
                    <tr>
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
                            <td><?= $item['table_number'] ?></td>
                            <td><?= $item['phone'] ?></td>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['date'] ?></td>
                            <td><?= (new DateTime($item['time_start']))->format('H:i') ?? '' ?></td>
                            <td><?= (new DateTime($item['time_end']))->format('H:i') ?? '' ?></td>
                            <td><?= $item['capacity'] ?></td>
                            <td><?= $item['comments'] ?></td>
                            <td><?= getStatusBadge($item['status']) ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php include(dirname(__DIR__) . '/../include/scripts.php'); ?>
</body>
</html>