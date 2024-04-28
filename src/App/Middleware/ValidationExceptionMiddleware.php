<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Interfaces\{
    MiddlewareInterface,
    NonAPIValidation
};
use Framework\Exceptions\ValidationException;

class ValidationExceptionMiddleware implements MiddlewareInterface, NonAPIValidation
{
    /**
     * Middleware class for handling ValidationException.
     *
     * This middleware catches any ValidationException thrown during the request processing
     * and performs the necessary actions to handle the exception. It stores the validation
     * errors in the session, removes sensitive fields from the form data, and redirects
     * the user back to the previous page.
     *
     * @param callable $next The next middleware in the pipeline.
     */
    public function process(callable $next, ?array &$params)
    {
        try {
            return $next($params);
        } catch (ValidationException $e) {
            $_SESSION['errors'] = $e->errors;

            $oldFormData = $_POST ?? [];

            $excludedFields = ['password', 'confirmPassword'];
            $formattedFormData = array_diff_key(
                $oldFormData,
                array_flip($excludedFields)
            );

            $_SESSION['oldFormData'] = $formattedFormData;

            $referer = $_SERVER['HTTP_REFERER'] ?? "/";

            redirectTo($referer);
        }
    }
}
