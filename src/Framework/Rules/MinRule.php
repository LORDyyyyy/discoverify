<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Interfaces\RuleInterface;
use InvalidArgumentException;

/**
 * The MinRule class implements the RuleInterface and provides validation for a minimum value.
 */
class MinRule implements RuleInterface
{
    /**
     * Validates if the field value is greater than or equal to the specified minimum value.
     *
     * @param array $formData The form data being validated.
     * @param string $field The name of the field being validated.
     * @param array $params The parameters for the validation rule.
     * @return bool Returns true if the validation passes, false otherwise.
     * @throws InvalidArgumentException If the minimum value parameter is missing.
     */
    public function validate(array $formData, string $field, array $params): bool
    {
        if (empty($params[0])) {
            throw new InvalidArgumentException('The Min rule requires a parameter.');
        }

        return (int) $formData[$field] >= (int) $params[0];
    }

    /**
     * Gets the error message for the minimum value validation rule.
     *
     * @param array $formData The form data being validated.
     * @param string $field The name of the field being validated.
     * @param array $params The parameters for the validation rule.
     * @return string The error message for the validation rule.
     * @throws InvalidArgumentException If the minimum value parameter is missing.
     */
    public function getMessage(array $formData, string $field, array $params): string
    {
        if (empty($params[0])) {
            throw new InvalidArgumentException('The Min rule requires a parameter.');
        }

        return "The field must be at least {$params[0]} characters long.";
    }
}
