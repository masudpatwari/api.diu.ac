<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckSameYear implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */

    public $param;

    public function __construct($param) {
        $this->param = $param;
    }

    public function passes($attribute, $value)
    {
        $year_str = date('Y', strtotime($this->param));
        $year_end = date('Y', strtotime($value));
        return ($year_str == $year_end) ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute year must be same to Starting Date Year.';
    }
}
