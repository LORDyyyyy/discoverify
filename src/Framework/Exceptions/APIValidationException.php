<?php

declare(strict_types=1);

namespace Framework\Exceptions;

use RuntimeException;

/**
 * Represents an exception that occurs when there is a validation error in an API request.
 */
class APIValidationException extends RuntimeException
{
    public array $errors;

    public function __construct(array $errors, int $code = 422)
    {
        $this->errors = $errors;
        parent::__construct(code: $code);
    }
}
