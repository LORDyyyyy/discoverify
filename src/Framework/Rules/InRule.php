<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Interfaces\RuleInterface;

/**
 * Class InRule
 *
 * Implements the RuleInterface and provides validation logic for checking if a value is in a given array.
 */
class InRule implements RuleInterface
{
    /**
     * Validates if the value of a field is in the given array of parameters.
     *
     * @param array $formData The form data being validated.
     * @param string $field The name of the field being validated.
     * @param array $params The array of parameters to check against.
     * @return bool Returns true if the value is in the array, false otherwise.
     */
    public function validate(array $formData, string $field, array $params): bool
    {
        return in_array($formData[$field], $params);
    }

    /**
     * Returns the error message to display when the validation fails.
     *
     * @param array $formData The form data being validated.
     * @param string $field The name of the field being validated.
     * @param array $params The array of parameters to check against.
     * @return string The error message to display.
     */
    public function getMessage(array $formData, string $field, array $params): string
    {
        return "The field must be one of the following values: " . implode(', ', $params);
    }
}
