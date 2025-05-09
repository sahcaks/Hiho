<?php

use app\admin\include\Redirect;
use app\helper\Enum\RoleEnum;

require_once dirname(__DIR__) . '/../config/config.php';
require_once dirname(__DIR__, 2) . '/admin/include/functions.php';

global $link;
try {
    if (!isAuthenticated()) {
        throw new Exception('Access denied');
    }
    $role_id = intval($_SESSION['role_id']);
    switch ($role_id) {
        case RoleEnum::ADMIN:
            require_once "sidebar/admin.php";
            break;
        case RoleEnum::USER:
            require_once "sidebar/user.php";
            break;
        case RoleEnum::MANAGER:
            require_once "sidebar/manager.php";
            break;
        default:
            throw new Exception('Role does not exist');
    }
} catch (Exception $e) {
    Redirect::home();
}
