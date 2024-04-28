<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Interfaces\MiddlewareInterface;

/**
 * Middleware that allows only guests to access the application.
 */
class GuestOnlyMiddleware implements MiddlewareInterface
{
    /**
     * Process the middleware.
     *
     * @param callable $next The next middleware to be called.
     * @return void
     */
    public function process(callable $next, ?array &$params): void
    {
        if (!empty($_SESSION['user'])) {
            if (in_array('HTTP_API_REQUEST', headers_list())) {
                echo json_encode(['error' => 'Unauthorized', 'code' => 401]);
                exit;
            }
            redirectTo('/');
        }

        $next($params);
    }
}
