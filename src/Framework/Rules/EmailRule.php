<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Interfaces\RuleInterface;

/**
 * Class EmailRule
 *
 * This class implements the RuleInterface and provides validation for email fields.
 */
class EmailRule implements RuleInterface
{
    /**
     * Validates the email field.
     *
     * @param array $formData The form data.
     * @param string $field The name of the field to validate.
     * @param array $params Additional parameters for validation (not used in this rule).
     * @return bool Returns true if the email is valid, false otherwise.
     */
    public function validate(array $formData, string $field, array $params): bool
    {
        return (bool) filter_var($formData[$field], FILTER_VALIDATE_EMAIL);
    }

    /**
     * Gets the error message for the email field.
     *
     * @param array $formData The form data.
     * @param string $field The name of the field.
     * @param array $params Additional parameters for validation (not used in this rule).
     * @return string The error message for the email field.
     */
    public function getMessage(array $formData, string $field, array $params): string
    {
        return "Invalid email";
    }
}
