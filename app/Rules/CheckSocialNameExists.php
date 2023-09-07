<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckSocialNameExists implements Rule
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
		$social_names = ["Facebook","Instagram","YouTube","LinkedIn","Twitter","WhatsApp","WeChat","Skype","Viber","Pinterest","Telegram"];
		return (in_array($value, $social_names)) ? true  : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute does not exists.';
    }
}