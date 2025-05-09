<?php require_once dirname(__DIR__, 2) . '/include/functions.php'?>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= isActiveLink(ADMIN_URL) ?>" aria-current="page" href="<?= ADMIN_URL ?>">
                    <span data-feather="home" class="align-text-bottom"></span>
                    <i class="fa fa-dashboard"></i> Панель управления
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= isActiveLink("/order/list.php") ?>"
                   href="<?= ADMIN_URL ?>/order/list.php">
                    <span data-feather="orders" class="align-text-bottom"></span>
                    <i class="fa fa-cart-plus"></i> Заказы
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= isActiveLink("/user/list.php") ?>"
                   href="<?= ADMIN_URL ?>/user/list.php">
                    <span data-feather="users" class="align-text-bottom"></span>
                    <i class="fa fa-user"></i> Пользователи
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= isActiveLink("/role/list.php") ?>"
                   href="<?= ADMIN_URL ?>/role/list.php">
                    <span data-feather="users" class="align-text-bottom"></span>
                    <i class="fa fa-address-book"></i> Роли
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= isActiveLink("/review/list.php") ?>"
                   href="<?= ADMIN_URL ?>/review/list.php">
                    <span data-feather="reviews" class="align-text-bottom"></span>
                    <i class="fa fa-comment"></i> Отзывы
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= isActiveLink("/dish/list.php") ?>"
                   href="<?= ADMIN_URL ?>/dish/list.php">
                    <span data-feather="dish" class="align-text-bottom"></span>
                    <i class="fa fa-cutlery"></i> Блюда
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= isActiveLink("/category/list.php") ?>"
                   href="<?= ADMIN_URL ?>/category/list.php">
                    <span data-feather="category" class="align-text-bottom"></span>
                    <i class="fa fa-cubes"></i> Категории
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= isActiveLink("/table_arrangement/list.php") ?>"
                   href="<?= ADMIN_URL ?>/table_arrangement/list.php">
                    <span data-feather="table-arrangement" class="align-text-bottom"></span>
                    <i class="fa fa-th-large"></i> Бронь
                </a>
            </li>
        </ul>
    </div>
</nav>
