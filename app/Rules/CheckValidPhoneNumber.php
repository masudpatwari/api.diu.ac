<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckValidPhoneNumber implements Rule
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
        $regx_code = "/(?:(^[+]?[(]?[0-9]{1,4}[)]?[-]?[0-9]{2,}([-0-9]{2,3})?(([\s\S]{5}[0-9]{2,4})?)?$)|(^\+{0,1}\d{8,}$)){1}/";
        return (preg_match($regx_code, $value))>0? true:false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute invalid.(ex. +8801234567, 985874, 985874-5, 985874 Ext-1233,985874-5 Ext-1233 ) ';
    }
}
