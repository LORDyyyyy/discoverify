<?php

namespace Framework\Rules;

use Framework\Interfaces\RuleInterface;
use InvalidArgumentException;

class LengthMaxRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        if (empty($params[0])) {
            throw new InvalidArgumentException("Maximum length not provided.");
        }

        return strlen($data[$field]) < (int) $params[0];
    }

    public function getMessage(array $data, string $field, array $params): string
    {
        return "The field {$field} must be less than {$params[0]} characters.";
    }
}
