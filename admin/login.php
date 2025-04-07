<?php

global $link;
require_once 'include/functions.php';

session_start();

if (isset($_POST['submit_enter'])) {

    $login = clear_string($link, $_POST["input_login"]);
    $pass = clear_string($link, $_POST["input_pass"]);


    if ($login && $pass) {
        $result = mysqli_query("SELECT * FROM reg_admin WHERE login = '$login' AND pass = '$pass'", $link);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);

            $_SESSION['auth_admin'] = 'yes_auth';

            header("Location: orders.php");
        } else {
            $msgerror = "Неверный Логин и(или) Пароль.";
        }


    } else {
        $msgerror = "Заполните все поля!";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="front/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="front/css/main.css" rel="stylesheet">

    <title>Sign in</title>
</head>
<body class="text-center">
<main class="form-signin w-100 m-auto">
    <form method="POST" action="login.php">
        <img class="mb-4" src="img/logo.svg" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

        <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>

        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="w-100 btn btn-lg btn-primary-hiho" type="submit">Sign in</button>
    </form>
</main>

<script src="front/bootstrap/js/bootstrap.js"></script>

<style>
    body {
        display: flex;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
        margin: 0;
        -webkit-text-size-adjust: 100%;
    }
</style>

</body>
</html>