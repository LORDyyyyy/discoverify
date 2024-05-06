<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Interfaces\RuleInterface;

/**
 * Class NumericRule
 * 
 * This class implements the RuleInterface and provides validation for numeric fields.
 */
class NumericRule implements RuleInterface
{
    /**
     * Validates if the value of a given field in the data array is numeric.
     *
     * @param array $data The data array to validate.
     * @param string $field The field to validate.
     * @param array $params Additional parameters (not used in this rule).
     * @return bool Returns true if the value is numeric, false otherwise.
     */
    public function validate(array $data, string $field, array $params): bool
    {
        return is_numeric($data[$field] ?? '');
    }

    /**
     * Gets the error message for the numeric validation rule.
     *
     * @param array $data The data array being validated.
     * @param string $field The field being validated.
     * @param array $params Additional parameters (not used in this rule).
     * @return string The error message for the numeric validation rule.
     */
    public function getMessage(array $data, string $field, array $params): string
    {
        return "Only numeric values are allowed.";
    }
}
