<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Interfaces\{
    MiddlewareInterface,
    APIValidation
};
use Framework\Exceptions\APIStatusCodeSend;
use Framework\HTTP;

/**
 * This class is responsible for handling API response codes and sending appropriate responses.
 * It implements the MiddlewareInterface and APIValidation interfaces.
 */
class APISendResponseCode implements MiddlewareInterface, APIValidation
{
    /**
     * Process the middleware.
     *
     * @param callable $next The next middleware to be called.
     * @param array|null $params The parameters passed to the middleware.
     * @return mixed The result of the next middleware.
     * @throws APIStatusCodeSend If an APIStatusCodeSend exception is caught.
     */
    public function process(callable $next, ?array &$params)
    {
        try {
            return $next($params);
        } catch (APIStatusCodeSend $e) {
            http_response_code($e->getCode());

            echo json_encode([
                'status' => $e->errors['status'] ?? HTTP::RESPONSE_CODES_TEXT[$e->getCode()],
                'code' => $e->getCode() ?? HTTP::BAD_REQUEST_STATUS_CODE,
                'errors' => array_values($e->errors['errors']) ?? []
            ]);

            exit;
        }
    }
}
