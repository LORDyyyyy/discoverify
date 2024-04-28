<?php

namespace Framework\Rules\FileRules;

use Framework\Interfaces\RuleInterface;
use InvalidArgumentException;

/**
 * Class MaxFileSize
 * 
 * This class implements the RuleInterface and provides a rule for validating the maximum file size.
 */
class MaxFileSizeRule implements RuleInterface
{
    /**
     * Validates the file size against the maximum allowed size.
     *
     * @param array $data The data being validated.
     * @param string $field The field being validated.
     * @param array $params The validation parameters.
     * @return bool Returns true if the file size is within the maximum allowed size, false otherwise.
     * @throws InvalidArgumentException If the file size parameter is not provided.
     */
    public function validate(array $data, string $field, array $params): bool
    {
        if (empty($params[0])) {
            throw new InvalidArgumentException("File size is not provided.");
        }

        $maxFileSizeMB = (int) $params[0] * 1024 * 1024;

        return $maxFileSizeMB > $data[$field]['size'];
    }

    /**
     * Returns the error message for when the file size is too large.
     *
     * @param array $data The data being validated.
     * @param string $field The field being validated.
     * @param array $params The validation parameters.
     * @return string The error message.
     */
    public function getMessage(array $data, string $field, array $params): string
    {
        return "File size is too large";
    }
}
