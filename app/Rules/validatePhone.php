<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class validatePhone implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return validatePhone($value) !== false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El formato del telefono ingresado no es correcto.';
    }
}
