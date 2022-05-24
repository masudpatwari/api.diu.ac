<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\EmployeeGroup;

class GroupSlugExists implements Rule
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
        $employee_group = $value;
        $group_array = EmployeeGroup::pluck('slug_name')->toArray();
        if (!empty($employee_group)) {
            foreach ($employee_group as $key => $name) {
                $in_array[] = in_array($name, $group_array);
            }
        }
        return (in_array(false, $in_array)) ? false  : true;
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