<?php

declare(strict_types=1);

namespace Framework;

use Framework\Interfaces\RuleInterface;
use Framework\Exceptions\{
    ValidationException,
    APIValidationException
};

class Validator
{
    private array $rules = [];

    /**
     * Add a new rule to the validator.
     *
     * @param string $alias the alias of the rule
     * @param RuleInterface $rule the rule to add
     */
    public function add(string $alias, RuleInterface $rule): void
    {
        $this->rules[$alias] = $rule;
    }

    /**
     * Validate the form data.
     *
     * @param array $formData the form data to validate
     * @param array $fields the fields to validate
     *
     * @throws ValidationException
     */
    public function validate(array $formData, array $fields, bool $isAPI = false): void
    {
        $errors = [];

        foreach ($fields as $fieldName => $rules) {
            foreach ($rules as $rule) {
                $ruleParams = [];

                if (str_contains($rule, ':')) {
                    [$rule, $ruleParams] = explode(':', $rule);
                    $ruleParams = explode(',', $ruleParams);
                }

                $ruleValidator = $this->rules[$rule];

                if ($ruleValidator->validate($formData, $fieldName, $ruleParams)) {
                    continue;
                }

                $errors[$fieldName][] = $ruleValidator->getMessage($formData, $fieldName, $ruleParams);
            }
        }

        if (count($errors)) {
            if ($isAPI)
                throw new APIValidationException($errors);
            else
                throw new ValidationException($errors);
        }
    }
}
