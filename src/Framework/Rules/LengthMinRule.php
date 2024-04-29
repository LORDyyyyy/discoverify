<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Interfaces\RuleInterface;
use InvalidArgumentException;

/**
 * This class represents a rule that checks if a string field has a minimum length.
 */
class LengthMinRule implements RuleInterface
{
    /**
     * Validates if the given field in the data array has a minimum length.
     *
     * @param array $data The data array to validate.
     * @param string $field The field to validate.
     * @param array $params The parameters for the validation rule.
     * @return bool Returns true if the field has a minimum length, false otherwise.
     * @throws InvalidArgumentException Throws an exception if the maximum length is not provided.
     */
    public function validate(array $data, string $field, array $params): bool
    {
        if (empty($params[0])) {
            throw new InvalidArgumentException("Maximum length not provided.");
        }

        return strlen($data[$field]) >= (int) $params[0];
    }

    /**
     * Gets the error message for the minimum length validation rule.
     *
     * @param array $data The data array being validated.
     * @param string $field The field being validated.
     * @param array $params The parameters for the validation rule.
     * @return string Returns the error message for the minimum length validation rule.
     */
    public function getMessage(array $data, string $field, array $params): string
    {
        return "The field must be at least {$params[0]} characters.";
    }
}
