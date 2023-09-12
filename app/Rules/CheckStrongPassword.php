<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckStrongPassword implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
		$regx_code = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-+]).{8,}$/";
		return (preg_match($regx_code, $value))>0? true:false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must 8 character long with 1 uppercase, 1 lowercase, 1 number and 1 special character.';
    }
}