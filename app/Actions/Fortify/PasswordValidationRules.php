<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function passwordRules(): array
    {
        return [
            'required',
            'string',
            Password::min(8)
                ->mixedCase()       // Aa
                ->numbers()         // 123
                ->symbols()         // !@#
                ->uncompromised(),  // Checks against leaked password DBs
            'confirmed'
        ];
    }
}
