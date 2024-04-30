<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Interfaces\RuleInterface;

/**
 * This class represents a rule that checks if a field contains only spaces.
 */
class NoSpacesOnlyRule implements RuleInterface
{
    /**
     * Validates if the given field in the data array contains only spaces.
     *
     * @param array $data The data array.
     * @param string $field The field to validate.
     * @param array $params Additional parameters (not used in this rule).
     * @return bool Returns true if the field does not contain only spaces, false otherwise.
     */
    public function validate(array $data, string $field, array $params): bool
    {
        return !!preg_match('/\S/', $data[$field]);
    }

    /**
     * Returns the error message for when the field contains only spaces.
     *
     * @param array $data The data array.
     * @param string $field The field that failed validation.
     * @param array $params Additional parameters (not used in this rule).
     * @return string The error message.
     */
    public function getMessage(array $data, string $field, array $params): string
    {
        return "The field must not contain only spaces.";
    }
}
