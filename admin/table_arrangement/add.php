<?php

use app\helper\Enum\TableStatusEnum;

session_start();
require_once dirname(__DIR__) . '/../config/config.php';
global $link;

$query = $link->prepare("SELECT id, table_number FROM `tables`");
$query->execute();
$tables = $query->get_result()->fetch_all(MYSQLI_ASSOC);
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
            <form method="POST" id="create" class="col-12 row g-3 p-4 needs-validation" novalidate>
                <div class="col-md-6">
                    <label for="phone" class="form-label">Телефон</label>
                    <input type="text" class="form-control" id="phone" name="phone" value=""
                           pattern="^\+?[1-9]\d{9,14}$"
                           minlength="10"
                           maxlength="15" required>
                    <div class="invalid-feedback">Введите корректный номер телефона.</div>
                </div>
                <div class="col-md-6">
                    <label for="name" class="form-label">Имя</label>
                    <input type="text" class="form-control" id="name" name="name" value="" minlength="2" required>
                    <div class="invalid-feedback">Введите имя длиной не менее 2 символов.</div>
                </div>
                <div class="col-md-6">
                    <label for="time-start" class="form-label">Время начала</label>
                    <select class="form-control" id="time-start" name="time_start" required></select>
                    <div class="invalid-feedback">Выберите правильное время начала!</div>
                </div>
                <div class="col-md-6">
                    <label for="time-end" class="form-label">Время окончания</label>
                    <select class="form-control" id="time-end" name="time_end" required></select>
                    <div class="invalid-feedback">Выберите правильное время окончания!</div>
                </div>
                <div class="col-md-6">
                    <label for="date" class="form-label">Дата</label>
                    <input type="date" class="form-control" id="date" name="date" value="" required>
                    <div class="invalid-feedback">Выберите дату.</div>
                </div>
                <div class="col-md-6">
                    <label for="capacity" class="form-label">Количество человек</label>
                    <input type="number" class="form-control" id="capacity" name="capacity" value="" min="1"
                           max="36" required>
                    <div class="invalid-feedback">Укажите количество человек от 1 до 36.</div>
                </div>
                <div class="col-md-6">
                    <label for="table_id" class="form-label">Номер стола</label>
                    <select name="table_id" id="table_id"
                            class="form-select" required>
                        <?php foreach ($tables as $table) { ?>
                            <option value="<?= $table['id'] ?>"><?= $table['table_number'] ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">Укажите номер стола.</div>
                </div>
                <div class="col-md-6">
                    <label for="status" class="form-label">Статус</label>
                    <select name="status" id="status"
                            class="form-select" required>
                        <?php foreach (TableStatusEnum::STATUS_LIST as $key => $status) { ?>
                                <?php if (TableStatusEnum::OPEN === $key) continue ?>
                            <option  value="<?= $key ?>"><?= $status ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">Выберите статус.</div>
                </div>
                <div class="col-md-6">
                    <label for="comments" class="form-label">Комментарии</label>
                    <textarea class="form-control" id="comments" rows="3" name="comments"></textarea>
                    <div class="invalid-feedback">Пожалуйста, добавьте комментарии.</div>
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