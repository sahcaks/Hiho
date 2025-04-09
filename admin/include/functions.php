<?php
require_once __DIR__ . '/../../database.php';
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../helper/helper.php';

if (!isAuthenticated()) redirect(HOME_URL);

const ROLES = [
    'admin' => 1,
];
function isAuthenticated(): bool
{
    return isset($_SESSION['name']);
}

function hasPermission(string $permission_name): bool
{
    global $link;
    $role_id = $_SESSION['role_id'];
    $stmt = $link->prepare("
        SELECT COUNT(*) FROM role_permissions
        INNER JOIN permissions ON role_permissions.permission_id = permissions.id
        WHERE role_permissions.role_id = ? AND permissions.permission_name = ?
    ");
    $stmt->bind_param('ss', $role_id, $permission_name);
    $stmt->execute();
    return $stmt->get_result()->fetch_row()[0] > 0;
}

function isAdmin(string $email): bool
{
    global $link;
    $result = mysqli_query($link, 'SELECT * FROM `users` WHERE email = "' . $email . '"');
    if ($result->num_rows > 0 && $result->fetch_assoc() === ROLES['admin']) {
        return true;
    }
    return false;
}

function getDomain(): string
{
    $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === FALSE ? 'http' : 'https';
    return $protocol . '://' . $_SERVER['HTTP_HOST'];
}

function currentUrl(): string
{
    return getDomain() . $_SERVER['REQUEST_URI'];
}

function image(string $image): string
{

    return getDomain() . '/' . strtolower(PROJECT_NAME) . '/' . $image;
}

function isActiveLink(string $url): string
{
    if (ADMIN_URL === $url && currentUrl() === getDomain() . ADMIN_URL . '/') {
        return 'active';
    }
    return currentUrl() === getDomain() . ADMIN_URL . $url ? 'active' : '';
}
