<?php

namespace app\admin\include;

class Response
{
    // Устанавливаем код состояния (HTTP статус)
    private static function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    // Отправляем заголовок
    private static function setHeader(string $key, string $value)
    {
        header("{$key}: {$value}");
    }

    // Отправка JSON-ответа
    private static function sendJson(array $data)
    {
        self::setHeader('Content-Type', 'application/json');
        echo json_encode($data);
        exit;
    }

    // Отправка успешного ответа (200 OK)
    public static function sendSuccess(array $data)
    {
        self::setStatusCode(200);  // Код 200 — успех
        self::sendJson($data);
    }

    // Отправка ошибки с кодом и сообщением
    public static function sendError(int $code, string $message)
    {
        self::setStatusCode($code);  // Устанавливаем соответствующий HTTP статус
        self::sendJson(['error' => $message]);
    }

    // Отправка ошибки 404 (не найдено)
    public static function sendNotFound(string $message = 'Resource not found')
    {
        self::sendError(404, $message);
    }

    // Отправка ошибки 400 (плохой запрос)
    public static function sendBadRequest(string $message = 'Bad request')
    {
        self::sendError(400, $message);
    }

    // Отправка ошибки 401 (не авторизован)
    public static function sendUnauthorized(string $message = 'Unauthorized')
    {
        self::sendError(401, $message);
    }

    // Отправка ошибки 405 (метод не разрешен)
    public static function sendMethodNotAllowed(string $message = 'Method Not Allowed')
    {
        self::sendError(405, $message);
    }

    // Отправка ошибки 500 (внутренняя ошибка сервера)
    public static function sendServerError(string $message = 'Internal Server Error')
    {
        self::sendError(500, $message);
    }
}