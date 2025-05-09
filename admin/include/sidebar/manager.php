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
                <a class="nav-link <?= isActiveLink("/table_arrangement/list.php") ?>"
                   href="<?= ADMIN_URL ?>/table_arrangement/list.php">
                    <span data-feather="table-arrangement" class="align-text-bottom"></span>
                    <i class="fa fa-th-large"></i> Бронь
                </a>
            </li>
        </ul>
    </div>
</nav>
