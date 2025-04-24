<?php

use app\admin\include\Redirect;
use app\helper\Enum\RoleEnum;

require_once dirname(__DIR__) . '/../config/config.php';

global $link;
try {
    if (!isAuthenticated()) {
        throw new Exception('Access denied');
    }
    $role_id = intval($_SESSION['role_id']);
    switch ($role_id) {
        case RoleEnum::ADMIN:
            require_once "dashboard/admin.php";
            break;
        case RoleEnum::USER:
            require_once "dashboard/user.php";
            break;
        case RoleEnum::MANAGER:
            require_once "dashboard/manager.php";
            break;
        default:
            throw new Exception('Role does not exist');
    }
} catch (Exception $e) {
    Redirect::home();
}
