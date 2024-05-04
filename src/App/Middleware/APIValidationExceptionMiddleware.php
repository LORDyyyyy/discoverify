<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Interfaces\{
    MiddlewareInterface,
    APIValidation
};
use Framework\Exceptions\APIValidationException;
use Framework\HTTP;

/**
 * Class APIValidationExceptionMiddleware
 * 
 * This middleware handles exceptions of type APIValidationException.
 * It captures the validation errors, stores them in the session, and returns them as JSON response.
 */
class APIValidationExceptionMiddleware implements MiddlewareInterface, APIValidation
{
    /**
     * Process the middleware.
     * 
     * @param callable $next The next middleware to be called
     * @return mixed The response returned by the next middleware
     * @throws APIValidationException If an API validation exception occurs
     */
    public function process(callable $next, ?array &$params)
    {
        try {
            return $next($params);
        } catch (APIValidationException $e) {
            $_SESSION['errors'] = $e->errors;

            echo json_encode(['errors' => $e->errors]);

            http_response_code(HTTP::BAD_REQUEST_STATUS_CODE);

            exit;
        }
    }
}
