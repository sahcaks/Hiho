<?php

session_start();
require_once dirname(__DIR__) . '/../config/config.php';
global $link;

$stmt = $link->prepare("SELECT * FROM roles WHERE id = ?");
$stmt->bind_param("i", $_GET["id"]);
$stmt->execute();
$role = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
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
                <h1 class="h2">Создание брони</h1>
                <a class="btn btn-secondary" href="list.php"> <i class="fa fa-arrow-left"></i> Назад</a>
            </div>
            <form method="post" id="update" class="col-12 row g-3 p-4 needs-validation" novalidate>
                <div class="col-md-12">
                    <input type="hidden" name="id" value="<?= $role['id'] ?>">
                    <label for="role-name" class="form-label">Роль</label>
                    <input type="text" class="form-control" id="role-name" name="role_name"
                           value="<?= $role['role_name'] ?>"
                           pattern="[A-Za-zА-Яа-яЁё\s]+"
                           minlength="2"
                           maxlength="30" required>
                    <div class="invalid-feedback">Неправильно укзано имя роли.</div>
                </div>
                <div class="col-12 d-flex justify-content-end align-items-center">
                    <button id="save" type="submit" class="btn btn-success">Сохранить</button>
                </div>
            </form>
        </main>
    </div>
</div>
<?php include(__DIR__ . '/../include/scripts.php'); ?>
<script type="module" src="../front/js/main/actions/index.js"></script>
</body>
</html>