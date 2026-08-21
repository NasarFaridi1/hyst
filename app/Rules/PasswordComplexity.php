<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordComplexity implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value) || strlen((string)$value) < 8) {
            $fail('The ' . str_replace('_', ' ', $attribute) . ' must be at least 8 characters long.');
            return;
        }

        if (!preg_match('/[A-Z]/', (string)$value)) {
            $fail('The ' . str_replace('_', ' ', $attribute) . ' must contain at least one uppercase letter (A–Z).');
            return;
        }

        if (!preg_match('/[a-z]/', (string)$value)) {
            $fail('The ' . str_replace('_', ' ', $attribute) . ' must contain at least one lowercase letter (a–z).');
            return;
        }

        if (!preg_match('/[0-9]/', (string)$value)) {
            $fail('The ' . str_replace('_', ' ', $attribute) . ' must contain at least one number (0–9).');
            return;
        }

        if (!preg_match('/[^A-Za-z0-9]/', (string)$value)) {
            $fail('The ' . str_replace('_', ' ', $attribute) . ' must contain at least one special character (@$!%*?&).');
            return;
        }
    }
}
