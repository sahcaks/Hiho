<?php
session_start();

global $link;
require_once __DIR__ . '/../include/functions.php';



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
            <form class="row g-3">
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" id="email">
                </div>
                <div class="col-md-6">
                    <label for="login" class="form-label">Login</label>
                    <input name="login" type="email" class="form-control" id="login">
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="password">
                </div>
                <div class="col-md-6">
                    <label for="inputState" class="form-label">Role</label>
                    <select id="inputState" name="role_id" class="form-select">
                        <?php foreach ($roles as $role) { ?>
                            <option><?= $role['role_name'] ?></option>
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