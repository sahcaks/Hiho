<?php require_once dirname(__DIR__, 2) . '/include/functions.php' ?>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= isActiveLink(ADMIN_URL) ?>" aria-current="page" href="<?= ADMIN_URL ?>">
                    <span data-feather="home" class="align-text-bottom"></span>
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= isActiveLink("/order/history.php") ?>"
                   href="<?= ADMIN_URL ?>/order/history.php">
                    <span data-feather="orders" class="align-text-bottom"></span>
                    <i class="fa fa-cart-plus"></i> Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= isActiveLink("/user/list.php") ?>"
                   href="<?= ADMIN_URL ?>/user/profile/list.php">
                    <span data-feather="users" class="align-text-bottom"></span>
                    <i class="fa fa-user"></i> Profile
                </a>
            </li>
        </ul>
    </div>
</nav>
