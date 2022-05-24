<?php

namespace App\Libraries;

class EnglishAlphabeticNumber
{
    /*public static function makeSlug($string)
    {
        return preg_replace('/\s+/u', '-', trim($string));
    }*/

    public static function number($number)
    {
        if ($number == '') {
            return '--';
        }

        $a = [
            1 => 'FIRST',
            2 => 'SECOND',
            3 => 'THIRD',
            4 => 'FOURTH',
            5 => 'FIFTH',
            6 => 'SIXTH',
            7 => 'SEVENTH',
            8 => 'EIGHTH',
            9 => 'NINETH',
            10 => 'TENTH',
            11 => 'ELEVENTH',
            12 => 'TWELFTH'
        ];
        if ($number > 13) {
            return '--';

        }
        return $a[$number];
    }
}


