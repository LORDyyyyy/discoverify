<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Interfaces\RuleInterface;
use InvalidArgumentException;


/**
 * The MaxRule class implements the RuleInterface and provides validation for a maximum value.
 */
class MaxRule implements RuleInterface
{
    /**
     * Validates if the field value is less than or equal to the specified maximum value.
     *
     * @param array $formData The form data being validated.
     * @param string $field The name of the field being validated.
     * @param array $params The parameters for the validation rule.
     * @return bool Returns true if the field value is valid, false otherwise.
     * @throws InvalidArgumentException If the rule parameters are missing.
     */
    public function validate(array $formData, string $field, array $params): bool
    {
        if (empty($params[0])) {
            throw new InvalidArgumentException('The Max rule requires a parameter.');
        }

        return (int) $formData[$field] <= (int) $params[0];
    }

    /**
     * Gets the error message for the maximum validation rule.
     *
     * @param array $formData The form data being validated.
     * @param string $field The name of the field being validated.
     * @param array $params The parameters for the validation rule.
     * @return string The error message for the maximum validation rule.
     * @throws InvalidArgumentException If the rule parameters are missing.
     */
    public function getMessage(array $formData, string $field, array $params): string
    {
        if (empty($params[0])) {
            throw new InvalidArgumentException('The Max rule requires a parameter.');
        }

        return "The field must be at most {$params[0]} characters long.";
    }
}
