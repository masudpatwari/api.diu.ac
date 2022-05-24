<?php

namespace App\Libraries;

class Slug
{
    /*public static function makeSlug($string)
    {
        return preg_replace('/\s+/u', '-', trim($string));
    }*/

    public static function makeSlug($string, $delimiter = '-')
    {
        $string = strtolower(trim($string));
        // Remove special characters
        $string = preg_replace("/[~`{}.'\"\!\@\#\$\%\^\&\*\(\)\_\=\+\/\?\>\<\,\[\]\:\;\|\\\]/", "", $string);

        // Replace blank space with delimeter
        $string = preg_replace("/[\/_|+ -]+/", $delimiter, $string);

        return $string;
    }
}


