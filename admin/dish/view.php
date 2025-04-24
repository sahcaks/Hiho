<?php
session_start();

global $link;
require_once __DIR__ . '/../include/functions.php';

$id = $_GET['id'];

$stmt = $link->prepare("SELECT * FROM dish INNER JOIN category ON dish.id_category = category.id_category WHERE id_dish = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$dish = $stmt->get_result()->fetch_assoc();
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
                <h1 class="h2">Просмотр блюда</h1>
                <a class="btn btn-secondary" href="list.php"> <i class="fa fa-arrow-left"></i> Назад</a>
            </div>
            <div class="card">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img id="dishImage"
                             src="../../img/dish/<?= htmlspecialchars($dish['image']) ?>"
                             alt="Изображение блюда"
                             class="img-fluid rounded-start">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title" id="dishName"><?= $dish['dish'] ?></h5>
                            <p class="card-text">
                                <strong>Категория:</strong> <span id="categoryName"><?= $dish['name_category'] ?></span>
                            </p>
                            <p class="card-text">
                                <strong>Вес:</strong> <span id="dishWeight"><?= $dish['weight'] ?></span>
                            </p>
                            <p class="card-text">
                                <strong>Рецепт:</strong> <span id="dishRecipe"><?= $dish['recipes'] ?></span>
                            </p>
                            <p class="card-text">
                                <strong>Цена:</strong> <span
                                        id="dishPrice"><?= number_format($dish['price'], 2) ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php include(__DIR__ . '/../include/scripts.php'); ?>
</body>
</html>