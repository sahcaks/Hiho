<?php
session_start();

global $link;
require_once __DIR__ . '/../include/functions.php';
if (!isset($_GET['id'])) {
    redirect('hiho/pages/errors/404.php');
}
$edit_id = $_GET['id'] ?? null;
$stmt = $link->prepare("
        SELECT * FROM user WHERE id_user = ?
    ");
    $stmt->bind_param('s', $edit_id);
    $stmt->execute();
$user = $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
$result = mysqli_query($link, "SELECT * FROM roles");
$roles = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row;
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
                <h1 class="h2">Create user</h1>
                <a class="btn btn-secondary" href="list.php"> <i class="fa fa-arrow-left"></i> Back</a>
            </div>
            <form method="post" action="" class="row g-3">
                <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" id="email" value="<?= $user['email'] ?>">
                </div>
                <div class="col-md-6">
                    <label for="login" class="form-label">Login</label>
                    <input name="login" type="email" class="form-control" id="login" value="<?= $user['login'] ?>">
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">New Password</label>
                    <input name="password" type="password" class="form-control" id="password">
                </div>
                <div class="col-md-6">
                    <label for="confirm-password" class="form-label">Confirm Password</label>
                    <input name="confirm-password" type="password" class="form-control" id="confirm-password">
                </div>
                <div class="col-md-6">
                    <label for="inputState" class="form-label">Role</label>
                    <select id="inputState" name="role_id" class="form-select">
                        <?php foreach ($roles as $role) { ?>
                            <option <?= $user['role_id'] === $role['id'] ? 'selected' : '' ?> ><?= $role['role_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>

        </main>
    </div>
</div>

<?php include(__DIR__ . '/../include/scripts.php'); ?>
</body>
</html>