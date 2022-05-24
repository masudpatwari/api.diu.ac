<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MacAddressValidate implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */

    public function __construct() {
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool|false|int
     */
    public function passes($attribute, $value)
    {
        return preg_match(
            "/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/", $value
        );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The MAC Address must be a valid address';
    }
}
