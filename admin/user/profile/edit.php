<?php
session_start();

global $link;
require_once dirname(__DIR__) . '/../include/functions.php';

$id = $_SESSION['id_user'];
$result = mysqli_query($link, "SELECT * FROM roles");
$roles = $user = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row;
    }
}
$stmt = $link->prepare('SELECT * FROM user WHERE id_user = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!doctype html>
<html lang="en">
<?php include(dirname(__DIR__) . '/../include/head.php'); ?>
<body>
<?php include(dirname(__DIR__) . '/../include/header.php'); ?>
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
        <?php include(dirname(__DIR__) . '/../include/sidebar.php'); ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Редактирование профиля</h1>
                <a class="btn btn-secondary" href="view.php"> <i class="fa fa-arrow-left"></i> Назад</a>
            </div>
            <form method="POST" id="update" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                <div class="mb-4 d-flex justify-content-around align-items-center">
                    <div class="d-flex align-self-baseline">
                        <div class="image-card">
                            <?php if (!empty($user['image'])) { ?>
                                <img src="../../../img/user/<?= $user['id_user'] . '/' . htmlspecialchars($user['image']) ?>"
                                     alt="Текущее изображение"
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
                            <div class="control-button edit-button" id="updateButton" data-id="<?= $user['id_user'] ?>"
                                 title="Обновить">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-pencil"
                                     viewBox="0 0 16 16">
                                    <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.25 9.25a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l9.25-9.25zM11.207 2L2 11.207V13h1.793L14 3.793 11.207 2zM15 3l-2-2-1 1 2 2 1-1z"/>
                                </svg>
                            </div>
                            <div class="control-button delete-button" id="deleteButton"
                                 data-id="<?= $user['id_user'] ?>"
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
                    <div class="d-flex flex-column w-75">
                        <input type="hidden" name="id" value="<?= $user['id_user'] ?>">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" id="email" required
                                   value="<?= $user['email'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="login" class="form-label">Имя пользователя</label>
                            <input name="login" type="text" class="form-control" id="login" required
                                   value="<?= $user['login'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Телефон</label>
                            <input name="phone" type="text" class="form-control" id="phone" required
                                   value="<?= $user['phone'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Роль</label>
                            <select id="role" name="role_id" class="form-select">
                                <?php foreach ($roles as $role) { ?>
                                    <option <?= intval($role['id']) === intval($user['role_id']) ? 'selected' : '' ?>
                                            value="<?= $role['id'] ?>"><?= $role['role_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Новый пароль</label>
                            <input type="password" class="form-control" id="newPassword"
                                   pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                                   name="newPassword">
                            <div class="invalid-feedback">
                                Пароль должен содержать не менее 8 символов, включая заглавные и строчные буквы, цифры и
                                специальные символы.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Подтвердите новый пароль</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                            <div class="invalid-feedback">Пароли не совпадают.</div>
                        </div>
                        <div class="col-12 d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-success">Сохранить</button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>

<?php include(dirname(__DIR__) . '/../include/scripts.php'); ?>
<script type="module" src="../../front/js/main/actions/index.js"></script>
<script type="module" src="../../front/js/user/index.js"></script>
</body>
</html>