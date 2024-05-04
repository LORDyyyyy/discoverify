<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Interfaces\RuleInterface;

/**
 * Class NamesRule
 * 
 * This class implements the RuleInterface and provides validation for fields that should contain only letters.
 */
class NamesRule implements RuleInterface
{
    /**
     * Validates the given field value.
     * 
     * @param array $data The data array containing the field value.
     * @param string $field The name of the field to validate.
     * @param array $params Additional parameters for validation (not used in this implementation).
     * @return bool Returns true if the field value contains only letters, false otherwise.
     */
    public function validate(array $data, string $field, array $params): bool
    {
        return !!preg_match('/^[a-zA-Z]+$/', $data[$field] ?? '');
    }

    /**
     * Returns the error message for the validation failure.
     * 
     * @param array $data The data array containing the field value.
     * @param string $field The name of the field to validate.
     * @param array $params Additional parameters for validation (not used in this implementation).
     * @return string The error message indicating that the field must contain only letters.
     */
    public function getMessage(array $data, string $field, array $params): string
    {
        return "The field must contain only letters.";
    }
}
