<?php
session_start();

global $link;
require_once __DIR__ . '/../include/functions.php';
$id = $_GET['id'];

$result = $link->query("SELECT id_category, name_category FROM category");
$categories = $dish = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

$stmt = $link->prepare("SELECT * FROM dish WHERE id_dish = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$dish = $stmt->get_result()->fetch_assoc();
?>

<!doctype html>
<html lang="en">
<?php include(__DIR__ . '/../include/head.php'); ?>
<body>
<?php include(__DIR__ . '/../include/header.php'); ?>
<style>
    .image-card {
        position: relative;
        width: 200px;
        height: 200px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .image-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .control-button {
        position: absolute;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(255, 255, 255, 0.8);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        border: none;
        cursor: pointer;
    }

    .control-button:hover {
        background-color: rgba(255, 255, 255, 1);
    }

    .edit-button {
        top: 8px;
        right: 8px;
    }

    .delete-button {
        bottom: 8px;
        right: 8px;
    }

    .file-input {
        display: none;
    }
</style>
<div class="container-fluid h-100">
    <div class="row">
        <?php include(__DIR__ . '/../include/sidebar.php'); ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Редактирование блюда</h1>
                <a class="btn btn-secondary" href="list.php"> <i class="fa fa-arrow-left"></i> Назад</a>
            </div>
            <form method="POST" id="update" enctype="multipart/form-data" class="needs-validation" novalidate>
                <input type="hidden" name="id" value="<?= $dish['id_dish'] ?>">
                <div class="mb-3">
                    <label for="dish" class="form-label">Название блюда</label>
                    <input type="text" name="dish" id="dish" class="form-control" required value="<?= $dish['dish'] ?>">
                    <div class="invalid-feedback">Пожалуйста, укажите название блюда.</div>
                </div>
                <div class="mb-3">
                    <label for="id_category" class="form-label">Категория</label>
                    <select name="id_category" id="id_category" class="form-select" required>
                        <option value="" disabled>Выберите категорию</option>
                        <?php foreach ($categories as $category) { ?>
                            <option <?= $category['id_category'] === $dish['id_category'] ? 'selected' : '' ?>
                                    value='<?= $category['id_category'] ?>'><?= $category['name_category'] ?></option>;
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback">Пожалуйста, выберите категорию.</div>
                </div>
                <div class="mb-3">
                    <label for="weight" class="form-label">Вес</label>
                    <input type="text" name="weight" id="weight" class="form-control" required
                           value="<?= $dish['weight'] ?>">
                    <div class="invalid-feedback">Пожалуйста, укажите вес блюда.</div>
                </div>
                <div class="mb-3">
                    <label for="recipes" class="form-label">Рецепт</label>
                    <textarea name="recipes" id="recipes" rows="3" class="form-control"
                              required><?= $dish['recipes'] ?></textarea>
                    <div class="invalid-feedback">Пожалуйста, укажите рецепт блюда.</div>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Цена</label>
                    <input type="number" step="0.01" name="price" id="price" class="form-control" required
                           value="<?= $dish['price'] ?>">
                    <div class="invalid-feedback">Пожалуйста, укажите цену блюда.</div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Изображение</label>
                    <div class="image-card">
                        <?php if (!empty($dish['image'])) { ?>
                            <img src="../../img/dish/<?= htmlspecialchars($dish['image']) ?>" alt="Текущее изображение"
                                 id="currentImage">
                        <?php } ?>
                        <img id="imagePreview" src="" alt="Предварительный просмотр" class="d-none">
                        <button
                                id="addImageButton"
                                type="button"
                                class="btn btn-outline-secondary d-flex align-items-center justify-content-center"
                                style="width: 100%; height: 100%;"
                        >
                            <i class="fa fa-plus-circle" style="font-size: 2rem;"></i>
                        </button>
                        <div class="control-button edit-button" id="updateButton" data-id="<?= $dish['id_dish'] ?>"
                             title="Обновить">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-pencil"
                                 viewBox="0 0 16 16">
                                <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.25 9.25a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.25-9.25zM11.207 2L2 11.207V13h1.793L14 3.793 11.207 2zM15 3l-2-2-1 1 2 2 1-1z"/>
                            </svg>
                        </div>
                        <div class="control-button delete-button" id="deleteButton" data-id="<?= $dish['id_dish'] ?>"
                             title="Удалить">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-x"
                                 viewBox="0 0 16 16">
                                <path
                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </div>
                        <input type="file" id="fileInput" class="file-input" name="image"
                               accept="image/jpeg, image/png, image/gif, image/jpg">
                    </div>
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