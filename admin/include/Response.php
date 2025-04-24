<?php
namespace app\admin\include;

use JetBrains\PhpStorm\NoReturn;

class Response
{
    private static function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    // Отправляем заголовок
    private static function setHeader(string $key, string $value): void
    {
        header("{$key}: {$value}");
    }

    #[NoReturn] private static function sendJson(array $data): void
    {
        self::setHeader('Content-Type', 'application/json');
        echo json_encode($data);
        exit;
    }

    #[NoReturn] public static function sendSuccess(array $data): void
    {
        self::setStatusCode(200);
        self::sendJson($data);
    }

    #[NoReturn] public static function sendError(int $code, string $message): void
    {
        self::setStatusCode($code);
        self::sendJson(['error' => $message]);
    }

    #[NoReturn] public static function sendNotFound(string $message = 'Resource not found'): void
    {
        self::sendError(404, $message);
    }

    #[NoReturn] public static function sendBadRequest(string $message = 'Bad request'): void
    {
        self::sendError(400, $message);
    }

    #[NoReturn] public static function sendUnauthorized(string $message = 'Unauthorized'): void
    {
        self::sendError(401, $message);
    }

    #[NoReturn] public static function sendMethodNotAllowed(string $message = 'Method Not Allowed'): void
    {
        self::sendError(405, $message);
    }

    #[NoReturn] public static function sendServerError(string $message = 'Internal Server Error'): void
    {
        self::sendError(500, $message);
    }
}