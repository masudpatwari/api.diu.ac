<?php
namespace App\classes;
use NumberToWords\NumberToWords;
/**
 * NumberToWord
 */
class NumberToWord
{

    public static function numberToWord($number) 
    {

      $numberToWords = new NumberToWords();
      $numberTransformer = $numberToWords->getNumberTransformer('en');
        
      $amount_in_word = $numberTransformer->toWords($number);

      return $amount_in_word;

    }

    
}

