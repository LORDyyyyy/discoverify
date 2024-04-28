<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Interfaces\MiddlewareInterface;
use App\Exceptions\SessionException;

/**
 * SessionMiddleware Class
 *
 * This class represents a middleware for managing sessions in the application.
 * It implements the MiddlewareInterface and provides a process method to handle the session logic.
 */
class SessionMiddleware implements MiddlewareInterface
{
    /**
     * Middleware for managing session in the application.
     *
     * @param callable $next The next middleware in the pipeline.
     * @return mixed The result of the next middleware.
     * @throws SessionException If the session is already active or if headers are already sent.
     */
    public function process(callable $next, ?array &$params)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new SessionException("Session is already active.");
        }

        if (headers_sent($filename, $line)) {
            throw new SessionException("Headers already sent. Consider enabling output buffering. Data output started from {$filename} at line {$line}.");
        }

        $cookie_expiration_time = isset($_POST['rememberMe']) ?
            ($_POST['rememberMe'] ? 365 * 24 * 3600 : 0) :
            0;

        session_set_cookie_params([
            'secure' => $_ENV['APP_ENV'] === 'production' ? true : false,
            'httponly' => true,
            'samesite' => 'lax',
            'lifetime' => $cookie_expiration_time,
        ]);

        session_start();

        $next($params);

        session_write_close();
    }
}
