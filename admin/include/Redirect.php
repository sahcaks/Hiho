<?php

namespace app\admin\include;

require_once dirname(__DIR__) . '/../config/config.php';

class Redirect
{
    /**
     * Перенаправляет на указанный URL.
     *
     * @param string $url URL для перенаправления.
     * @param int $statusCode Код состояния HTTP (по умолчанию 302).
     */
    public static function to(string $url, int $statusCode = 302): void
    {
        if (!headers_sent()) {
            http_response_code($statusCode);
            header("Location: $url");
            exit;
        }

        throw new \RuntimeException("Заголовки уже отправлены, перенаправление невозможно.");
    }

    /**
     * Перенаправляет на предыдущую страницу, если она доступна.
     *
     * @param int $statusCode Код состояния HTTP (по умолчанию 302).
     */
    public static function back(int $statusCode = 302): void
    {
        $referrer = $_SERVER['HTTP_REFERER'] ?? null;

        if ($referrer) {
            self::to($referrer, $statusCode);
        }

        throw new \RuntimeException("Нет информации о предыдущей странице для перенаправления.");
    }

    /**
     * Перенаправляет на главную страницу.
     *
     * @param int $statusCode Код состояния HTTP (по умолчанию 302).
     */
    public static function home(int $statusCode = 302): void
    {
        self::to(HOME_URL, $statusCode);
    }
}
