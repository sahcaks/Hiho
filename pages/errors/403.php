<?php require_once dirname(__DIR__) . '/../config/config.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Bootstrap 5 403 page with image</title>
    <link href="<?= ADMIN_FRONT_URL ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="d-flex align-items-center justify-content-center vh-100">
    <div class="text-center row">
        <div class=" col-md-6">
            <img src="https://cdn.pixabay.com/photo/2017/03/09/12/31/error-2129569__340.jpg" alt=""
                 class="img-fluid">
        </div>
        <div class=" col-md-6 mt-5">
            <p class="fs-3"><span class="text-danger">Opps!</span> Page not found.</p>
            <p class="lead">
                The page you’re looking for doesn’t exist.
            </p>
            <button onclick="window.history.go(-1); return false;" class="btn btn-primary">Назад</button>
        </div>

    </div>
</div>
</body>

</html>