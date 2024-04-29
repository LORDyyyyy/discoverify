<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Interfaces\RuleInterface;

/**
 * Class RequiredRules
 * Implements the RuleInterface for validating required fields.
 */
class RequiredRules implements RuleInterface
{
    /**
     * Validates if the specified field in the form data is not empty.
     *
     * @param array $formData The form data to validate.
     * @param string $field The field to validate.
     * @param array $params Additional parameters (not used in this rule).
     * @return bool Returns true if the field is not empty, false otherwise.
     */
    public function validate(array $formData, string $field, array $params): bool
    {
        return !empty($formData[$field]);
    }

    /**
     * Returns the error message for the required field validation.
     *
     * @param array $formData The form data that failed validation.
     * @param string $field The field that failed validation.
     * @param array $params Additional parameters (not used in this rule).
     * @return string The error message for the required field validation.
     */
    public function getMessage(array $formData, string $field, array $params): string
    {
        return "This field is required.";
    }
}
