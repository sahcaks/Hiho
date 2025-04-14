<?php

function redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);

    exit();
}

function clear_string(mysqli $link, string $cl_str): string
{
    $cl_str = strip_tags($cl_str);
    $cl_str = mysqli_real_escape_string($link, $cl_str);
    return trim($cl_str);
}

function ensurePostRequest()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405); // Метод не разрешен
        echo json_encode(['error' => 'Метод запроса не поддерживается.']);
        exit;
    }
}