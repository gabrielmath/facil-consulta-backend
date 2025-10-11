<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidEmailDomain implements ValidationRule
{
    protected array $commonDomains = [
        'gmail.com',
        'hotmail.com',
        'outlook.com',
        'yahoo.com',
        'icloud.com',
        'live.com',
        'aol.com',
        'msn.com',
        'uol.com.br',
        'bol.com.br',
        'terra.com.br',
        'ig.com.br',
    ];

    protected array $commonTypos = [
        'gmal.com'    => 'gmail.com',
        'gmial.com'   => 'gmail.com',
        'gnail.com'   => 'gmail.com',
        'gmai.com'    => 'gmail.com',
        'hotmial.com' => 'hotmail.com',
        'hotmil.com'  => 'hotmail.com',
        'outlok.com'  => 'outlook.com',
        'yaho.com'    => 'yahoo.com',
        'yhoo.com'    => 'yahoo.com',
        'icloud.co'   => 'icloud.com',
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Se não for um e-mail válido, nem continua
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $fail('Este e-mail não existe ou está incompleto, verifique e tente novamente.');
            return;
        }

        // Extrai o domínio após o @
        $domain = strtolower(substr(strrchr($value, "@"), 1));

        // Se o domínio estiver escrito errado (typo conhecido)
        if (isset($this->commonTypos[$domain])) {
            $fail('Este e-mail não existe ou está incompleto, verifique e tente novamente.');
            return;
        }

        // Se o domínio for muito parecido com um conhecido (fuzzy match leve)
        foreach ($this->commonDomains as $validDomain) {
            if (levenshtein($domain, $validDomain) <= 2) {
                $fail('Este e-mail não existe ou está incompleto, verifique e tente novamente.');
                return;
            }
        }
    }
}
