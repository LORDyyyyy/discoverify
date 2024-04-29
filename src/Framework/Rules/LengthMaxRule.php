<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Interfaces\RuleInterface;
use InvalidArgumentException;

/**
 * This class represents a rule that checks if a string field has a maximum length.
 */
class LengthMaxRule implements RuleInterface
{
    /**
     * Validates if the length of a field value is less than the specified maximum length.
     *
     * @param array $data The data to be validated.
     * @param string $field The field to be validated.
     * @param array $params The validation parameters.
     * @return bool Returns true if the field value length is less than the maximum length, false otherwise.
     * @throws InvalidArgumentException Throws an exception if the maximum length is not provided.
     */
    public function validate(array $data, string $field, array $params): bool
    {
        if (empty($params[0])) {
            throw new InvalidArgumentException("Maximum length not provided.");
        }

        return strlen($data[$field]) < (int) $params[0];
    }

    /**
     * Gets the error message for the validation rule.
     *
     * @param array $data The data being validated.
     * @param string $field The field being validated.
     * @param array $params The validation parameters.
     * @return string The error message for the validation rule.
     */
    public function getMessage(array $data, string $field, array $params): string
    {
        return "The field must be less than {$params[0]} characters.";
    }
}
