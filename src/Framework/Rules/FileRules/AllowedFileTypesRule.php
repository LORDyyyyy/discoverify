<?php

namespace Framework\Rules\FileRules;

use Framework\Interfaces\RuleInterface;
use InvalidArgumentException;

/**
 * Class AllowedFileTypesRule
 * 
 * This class implements the RuleInterface and provides a rule for validating allowed file types.
 */
class AllowedFileTypesRule implements RuleInterface
{
    /**
     * Validates if the file type is allowed.
     *
     * @param array $data The data to be validated.
     * @param string $field The field to be validated.
     * @param array $params The allowed file types.
     * @return bool Returns true if the file type is allowed, false otherwise.
     * @throws InvalidArgumentException Throws an exception if the allowed file types are not provided.
     */
    public function validate(array $data, string $field, array $params): bool
    {
        if (empty($params)) {
            throw new InvalidArgumentException("Allowed file types are not provided.");
        }

        $clientMimeType = $data[$field]['type'];
        $allowedMimeTypes = $params;

        return in_array($clientMimeType, $allowedMimeTypes);
    }

    /**
     * Gets the error message for when the file type is not allowed.
     *
     * @param array $data The data that was validated.
     * @param string $field The field that was validated.
     * @param array $params The allowed file types.
     * @return string The error message.
     */
    public function getMessage(array $data, string $field, array $params): string
    {
        return "File type is not allowed";
    }
}
