<?php
/**
 * Created by PhpStorm.
 * User: lemon
 * Date: 9/20/19
 * Time: 3:19 PM
 */

namespace App\Exceptions;

use Exception;

class StudentFoundWithSameIDException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        \Log::debug('User not found');
    }
}