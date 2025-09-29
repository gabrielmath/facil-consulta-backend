<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FullNameRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $parts = preg_split('/\s+/', trim($value));
        if (count($parts) < 2) {
            $fail('Informe seu nome completo, exemplo: José da Silva.');
        }
    }
}
