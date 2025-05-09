<?php
session_start();

global $link;
require_once dirname(__DIR__) . '/include/functions.php';
require_once 'functions.php';

$result = mysqli_query($link, "SELECT * FROM orders");
$data = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[$row['id']] = $row;
        $data[$row['id']]['items'] = getOrderItems($link, $row['id']);
    }
}
?>

<!doctype html>
<html lang="en">
<?php include(__DIR__ . '/../include/head.php'); ?>
<body>
<?php include(__DIR__ . '/../include/header.php'); ?>

<div class="container-fluid h-100">
    <div class="row">
        <?php include(__DIR__ . '/../include/sidebar.php'); ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Заказы</h1>
            </div>
            <div class="table-responsive">
                <table id="table-data" class="table table-striped text-center align-middle" style="width:100%">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Order list</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $item) { ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['phone'] ?></td>
                            <td class="col-6">
                                <ul class="text-start list-unstyled">
                                    <?php array_map(function ($value) {
                                        echo '<br/>';
                                        echo '<li>' . $value['dish'] . ' (' . $value['quantity'] . ') </li>';
                                        echo '<li>' . $value['weight'] . '</li>';
                                        echo '<li>' . $value['price'] . '</li>';
                                        echo '<li>' . $value['recipes'] . '</li>';
                                    }, $item['items']) ?>
                                </ul>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php include(__DIR__ . '/../include/scripts.php'); ?>
</body>
</html>

