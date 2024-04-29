<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Interfaces\RuleInterface;

/**
 * Class MatchRule
 *
 * This class implements the RuleInterface and provides validation for matching fields.
 */
class MatchRule implements RuleInterface
{
    /**
     * Validates if the specified field matches another field in the form data.
     *
     * @param array $formData The form data.
     * @param string $field The field to validate.
     * @param array $params Additional parameters.
     * @return bool Returns true if the fields match, false otherwise.
     */
    public function validate(array $formData, string $field, array $params): bool
    {
        $fieldOne = $formData[$field];
        $fieldTwo = $formData[$params[0]];

        return $fieldOne === $fieldTwo;
    }

    /**
     * Gets the error message for when the fields do not match.
     *
     * @param array $formData The form data.
     * @param string $field The field to validate.
     * @param array $params Additional parameters.
     * @return string The error message.
     */
    public function getMessage(array $formData, string $field, array $params): string
    {
        return "The fields must match.";
    }
}
