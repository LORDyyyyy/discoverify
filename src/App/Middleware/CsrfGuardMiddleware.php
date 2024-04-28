<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Exceptions\ValidationException;
use Framework\Interfaces\{
    MiddlewareInterface,
    NonAPIValidation
};

/**
 * Class CsrfGuardMiddleware
 *
 * This middleware class is responsible for protecting against CSRF attacks.
 * It checks the request method and verifies the CSRF token before allowing the request to proceed.
 */
class CsrfGuardMiddleware implements MiddlewareInterface, NonAPIValidation
{
    /**
     * Process the CSRF token validation for incoming requests.
     *
     * @param callable $next The next middleware in the pipeline.
     * @throws ValidationException If the CSRF token is invalid.
     */
    public function process(callable $next, ?array &$params)
    {
        $requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);
        $validMethods = ['POST', 'PATCH', 'DELETE', 'PUT'];

        if (in_array($requestMethod, $validMethods)) {
            if ($_SESSION['token'] !== $_POST['token']) {
                throw new ValidationException(['token' => ['Invalid CSRF token']]);
            }

            unset($_SESSION['token']);
        }

        $next($params);
    }
}
