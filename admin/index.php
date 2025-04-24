<?php
session_start();
global $link;
require_once __DIR__ . '/include/functions.php';

?>

<!doctype html>
<html lang="en">
<?php include __DIR__ . '/include/head.php'; ?>
<body>

<?php include(__DIR__ . '/include/header.php'); ?>

<div class="container-fluid h-100">
    <div class="row h-100">
        <?php include __DIR__ . '/include/sidebar.php'; ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>
            <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
                <?php require_once __DIR__ . '/include/dashboard.php'?>
            </div>
        </main>
    </div>
</div>

<?php include __DIR__ . '/include/scripts.php'; ?>
</body>
</html>
