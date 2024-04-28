<?php

namespace Framework\Rules;

use Framework\Interfaces\RuleInterface;

class NoSpacesOnlyRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        return preg_match('/\S/', $data[$field]);
    }

    public function getMessage(array $data, string $field, array $params): string
    {
        return "The field {$field} must not contain only spaces.";
    }
}
