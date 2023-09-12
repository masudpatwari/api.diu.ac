<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\classes\vestacp;

class EmailAccountExists implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */


    public function __construct() {

        $vestacp_host = env('VESTA_HOSTNAME');
        $vestacp_username = env('VESTA_USERNAME');
        $vestacp_password = env('VESTA_PASSWORD');
        $vestacp_returncode = env('VESTA_RETURNCODE');
        $vestacp_email_domain = env('VESTA_EMAIL_DOMAIN');

        $this->vestacpObj = new vestacp( $vestacp_host, $vestacp_username, $vestacp_password, $vestacp_returncode, $vestacp_email_domain);

    }

    public function passes($attribute, $value)
    {
        $account_list = $this->vestacpObj->list_of_mail_accounts_id();
        $value = explode('@', $value)[0];
        return ! in_array($value,$account_list);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is already exists as email address in server !';
    }
}
