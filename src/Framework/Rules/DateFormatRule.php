<?php

namespace Framework\Rules;

use Framework\Interfaces\RuleInterface;
use InvalidArgumentException;

/**
 * The DateFormatRule class implements the RuleInterface and provides validation for date formats.
 */
class DateFormatRule implements RuleInterface
{
    /**
     * Validates if the given field in the data array matches the specified date format.
     *
     * @param array $data The data array to validate.
     * @param string $field The field to validate.
     * @param array $params The parameters array containing the date format.
     * @return bool Returns true if the field matches the date format, false otherwise.
     * @throws InvalidArgumentException If the date format is not provided.
     */
    public function validate(array $data, string $field, array $params): bool
    {
        if (empty($params[0])) {
            throw new InvalidArgumentException("Date format is not provided.");
        }

        $parsedDate = date_parse_from_format($params[0], $data[$field]);

        return $parsedDate['error_count'] === 0 &&
            $parsedDate['warning_count'] === 0;
    }

    /**
     * Returns the error message for the validation failure.
     *
     * @param array $data The data array being validated.
     * @param string $field The field being validated.
     * @param array $params The parameters array containing the date format.
     * @return string The error message indicating the required date format.
     */
    public function getMessage(array $data, string $field, array $params): string
    {
        return "The field {$field} must be in the format {$params[0]}.";
    }
}
