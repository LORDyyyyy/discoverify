<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Interfaces\RuleInterface;

/**
 * Class NoSpacesAtAll
 * 
 * This class implements the RuleInterface and provides validation for checking if a field contains any spaces.
 */
class NoSpacesAtAll implements RuleInterface
{
    /**
     * Validates if the given field in the data array contains any spaces.
     * 
     * @param array $data The data array to validate.
     * @param string $field The field to validate.
     * @param array $params Additional parameters for validation (not used in this implementation).
     * @return bool Returns true if the field does not contain any spaces, false otherwise.
     */
    public function validate(array $data, string $field, array $params): bool
    {
        return !preg_match('/\s/', $data[$field]);
    }

    /**
     * Returns the error message for when the field contains spaces.
     * 
     * @param array $data The data array being validated.
     * @param string $field The field being validated.
     * @param array $params Additional parameters for validation (not used in this implementation).
     * @return string The error message indicating that the field must not contain any spaces.
     */
    public function getMessage(array $data, string $field, array $params): string
    {
        return "The field must not contain any spaces.";
    }
}
