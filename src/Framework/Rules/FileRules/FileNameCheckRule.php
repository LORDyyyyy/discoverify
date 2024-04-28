<?php

namespace Framework\Rules\FileRules;

use Framework\Interfaces\RuleInterface;

class FileNameCheckRule implements RuleInterface
{
    /**
     * Validates the file name.
     *
     * @param array $data The data to be validated.
     * @param string $field The field to be validated.
     * @param array $params Additional parameters for validation.
     * @return bool Returns true if the file name is valid, false otherwise.
     */
    public function validate(array $data, string $field, array $params): bool
    {
        $originalFileName = $data[$field]['name'];

        return preg_match('/^[A-za-z0-9\s._-]+$/', $originalFileName);
    }

    /**
     * Gets the error message for an invalid file name.
     *
     * @param array $data The data being validated.
     * @param string $field The field being validated.
     * @param array $params Additional parameters for validation.
     * @return string The error message for an invalid file name.
     */
    public function getMessage(array $data, string $field, array $params): string
    {
        return "File name is invalid";
    }
}
