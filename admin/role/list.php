<?php

use app\helper\Enum\RoleEnum;

session_start();
global $link;
require_once __DIR__ . '/../include/functions.php';

$result = mysqli_query($link, "SELECT * FROM roles");
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

<div class="container-fluid h-100">
    <div class="row">
        <?php include(__DIR__ . '/../include/sidebar.php'); ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Роли</h1>
                <a class="btn btn-success" href="add.php"> <i class="fa fa-plus"></i> Добавить</a>
            </div>
            <div class="table-responsive">
                <table id="table-data" class="table table-striped text-center align-middle" style="width:100%">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $item) { ?>
                        <tr>
                            <td><?= $item['id'] ?></td>
                            <td><?= $item['role_name'] ?></td>
                            <td>
                                <a class="btn btn-outline-success btn-sm"
                                   href="edit.php?id=<?= $item['id'] ?>"><i
                                            class="fa fa-pencil"></i></a>
                                <?php if (RoleEnum::ADMIN !== (int)$item['id']) { ?>
                                    <a class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                       data-bs-target="#confirmDeleteModal" data-url="actions/remove.php"
                                       data-remove-id="<?= $item['id'] ?>"><i
                                                class="fa fa-trash"></i></a>
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

<?php include(__DIR__ . '/../include/scripts.php'); ?>
</body>
</html>

