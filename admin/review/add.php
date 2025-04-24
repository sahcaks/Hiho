<?php
session_start();

require_once __DIR__ . '/../include/functions.php';
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
                <h1 class="h2">Создание категории</h1>
                <a class="btn btn-secondary" href="list.php"> <i class="fa fa-arrow-left"></i> Назад</a>
            </div>
            <form id="create" method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="content" class="form-label">Комментарий</label>
                    <textarea name="content" id="content" rows="3" class="form-control" required></textarea>
                    <div class="invalid-feedback">Пожалуйста, укажите комментарий.</div>
                </div>
                <div class="mb-3">
                    <label for="rating" class="form-label">Рейтинг</label>
                    <input type="number" max="5" min="1" step="1" name="rating" id="rating" class="form-control" required>
                    <div class="invalid-feedback">Пожалуйста, укажите рейтинг.</div>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Пользователь</label>
                    <input type="text" value="" name="username" id="username" class="form-control" required>
                    <div class="invalid-feedback">Пожалуйста, укажите пользователя.</div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Создать</button>
                </div>
            </form>
        </main>
    </div>
</div>

<?php include(__DIR__ . '/../include/scripts.php'); ?>
<script type="module" src="../front/js/main/actions/index.js"></script>
</body>
</html>