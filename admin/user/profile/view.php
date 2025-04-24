<?php
session_start();

global $link;
require_once dirname(__DIR__) . '/../include/functions.php';

$id = $_SESSION['id_user'];

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
<div class="container-fluid h-100">
    <div class="row">
        <?php include(dirname(__DIR__) . '/../include/sidebar.php'); ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Профиль</h1>
            </div>
            <div class="card p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="edit-avatar">
                        <img id="userAvatar"
                             src="../../../img/user/<?= $user['id_user'] . '/' . $user['image'] ?>"
                             alt="Аватар пользователя"
                             class="profile-avatar">
                    </div>

                    <div class="ms-4">
                        <h4> <?= $user['login'] ?></h4>
                        <p class="text-muted"><strong>Email:</strong> <?= $user['email'] ?></p>
                        <p class="text-muted"><strong>Phone:</strong> <?= $user['phone'] ?></p>
                        <p class="text-muted"><strong>Balance:</strong> <?= $user['bonus_balance'] ?></p>
                    </div>
                    <div class="d-flex justify-content-end align-self-baseline w-100">
                        <a href="edit.php" class="btn btn-success">Редактировать</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include(dirname(__DIR__) . '/../include/scripts.php'); ?>
</body>
</html>