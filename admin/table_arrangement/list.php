<?php
session_start();

global $link;
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
            <?php if (hasPermission('create_post')) { ?>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Table arrangement</h1>
                    <a class="btn btn-success" href="add.php"> <i class="fa fa-plus"></i> Create</a>
                </div>

            <?php } ?>
            <div style="overflow-x: auto;" class="d-flex justify-content-between flex-column flex-xl-row">
                <div class="grid-stack" style="width: 900px"></div>
                <div>
                    <a onclick="saveGrid()" class="btn btn-primary" href="#">Save</a>
                    <a onclick="loadGrid()" class="btn btn-primary" href="#">Load</a>
                    <a onclick="clearGrid()" class="btn btn-primary" href="#">Clear</a>
                </div>
            </div>
        </main>
    </div>
</div>
<script src="/hiho/node_modules/gridstack/dist/gridstack-all.js"></script>
<link href="/hiho/node_modules/gridstack/dist/gridstack.min.css" rel="stylesheet"/>
<link href="../front/css/gridstack.css" rel="stylesheet"/>
<script src="../front/js/gridstack/gridstack.js"></script>
<?php include(__DIR__ . '/../include/scripts.php'); ?>
</body>
</html>

