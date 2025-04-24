<?php
session_start();

global $link;
require_once __DIR__ . '/../include/functions.php';
$id = $_GET['id'];

$stmt = $link->prepare("SELECT id_category, name_category FROM category WHERE id_category = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$category = $stmt->get_result()->fetch_assoc();
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
                <h1 class="h2">Редактирование категории</h1>
                <a class="btn btn-secondary" href="list.php"> <i class="fa fa-arrow-left"></i> Назад</a>
            </div>
            <form method="POST" id="update" class="needs-validation" novalidate>
                <input type="hidden" name="id" value="<?= $category['id_category'] ?>">
                <div class="mb-3">
                    <label for="category" class="form-label">Название категории</label>
                    <input type="text" name="name_category" id="category" class="form-control" required
                           value="<?= $category['name_category'] ?>">
                    <div class="invalid-feedback">Пожалуйста, укажите название категории.</div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Сохранить</button>
                </div>
            </form>
        </main>
    </div>
</div>
<?php include(__DIR__ . '/../include/scripts.php'); ?>
<script type="module" src="../front/js/main/actions/index.js"></script>
</body>
</html>