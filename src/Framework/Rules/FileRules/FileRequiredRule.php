<?php

namespace Framework\Rules\FileRules;

use Framework\Interfaces\RuleInterface;

/**
 * Class FileRequired
 *
 * This rule is used to validate if a file is present or required in a given context.
 * It implements the RuleInterface, which defines the contract for all rule classes.
 */
class FileRequiredRule implements RuleInterface
{
    /**
     * Validates if a file is required.
     * See: https://www.php.net/manual/en/features.file-upload.errors.php
     *
     * @param array $data The data to be validated.
     * @param string $field The field to be validated.
     * @param array $params Additional parameters for validation (not used in this rule).
     * @return bool Returns true if the file is required and exists, false otherwise.
     */
    public function validate(array $data, string $field, array $params): bool
    {
        return ($data[$field]['error']  === UPLOAD_ERR_OK);
    }

    /**
     * Gets the error message for a required file.
     *
     * @param array $data The data to be validated.
     * @param string $field The field to be validated.
     * @param array $params Additional parameters for validation (not used in this rule).
     * @return string The error message for a required file.
     */
    public function getMessage(array $data, string $field, array $params): string
    {
        return "File is required";
    }
}
