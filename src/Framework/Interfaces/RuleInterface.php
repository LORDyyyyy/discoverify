<?php

declare(strict_types=1);

namespace Framework\Interfaces;

/**
 * This interface represents a rule that can be used for form validation.
 */
interface RuleInterface
{
    /**
     * Validates the given form data based on the rule.
     *
     * @param array $formData The form data to be validated.
     * @param string $field The field to be validated.
     * @param array $params Additional parameters for the validation rule.
     * @return bool Returns true if the validation passes, false otherwise.
     */
    public function validate(array $formData, string $field, array $params): bool;

    /**
     * Gets the error message for the validation rule.
     *
     * @param array $formData The form data that was validated.
     * @param string $field The field that was validated.
     * @param array $params Additional parameters for the validation rule.
     * @return string The error message for the validation rule.
     */
    public function getMessage(array $formData, string $field, array $params): string;
}
