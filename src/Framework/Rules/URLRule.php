<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Interfaces\RuleInterface;

/**
 * Class URLRule
 *
 * This class implements the RuleInterface and provides validation for URL fields.
 */
class URLRule implements RuleInterface
{
    /**
     * Validates the given URL field.
     *
     * @param array $formData The form data.
     * @param string $field The name of the field to validate.
     * @param array $params Additional parameters for validation (not used in this rule).
     * @return bool Returns true if the URL is valid, false otherwise.
     */
    public function validate(array $formData, string $field, array $params): bool
    {
        return (bool) filter_var($formData[$field], FILTER_VALIDATE_URL);
    }

    /**
     * Returns the error message for an invalid URL field.
     *
     * @param array $formData The form data.
     * @param string $field The name of the field.
     * @param array $params Additional parameters for validation (not used in this rule).
     * @return string The error message.
     */
    public function getMessage(array $formData, string $field, array $params): string
    {
        return "Invalid URL";
    }
}
