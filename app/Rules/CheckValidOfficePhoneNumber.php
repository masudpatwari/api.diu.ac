<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckValidOfficePhoneNumber implements Rule
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
        $regx_code = "/^[+]?[(]?[0-9]{1,4}[)]?[-]?[0-9]{2,}([-0-9]{2,9}, Ext. - [0-9]{3})/";
        return (preg_match($regx_code, $value))>0? true:false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute invalid.ex - (+88-02-55040891, Ext. - 999) ';
    }
}
