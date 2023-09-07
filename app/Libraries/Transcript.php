<?php

namespace App\Libraries;

class Transcript
{
    public static function creditHour($allocatedCourse, $code)
    {
        $data = '-';
        if (!is_array($allocatedCourse)) {
            return $data;
        }
        foreach ($allocatedCourse as $singleResult) {

            if ($singleResult['code'] == trim($code)) {
                $data = $singleResult['credit'] ?? '-';
                break;
            }
        }
        return $data;
    }

    public static function gradeEarned($allocatedCourse, $code)
    {
        $data = '-';
        if (!is_array($allocatedCourse)) {
            return $data;
        }
        foreach ($allocatedCourse as $singleResult) {

            if ($singleResult['code'] == trim($code)) {
                $data = $singleResult['marks']['letter_grade'] ?? '-';
                break;
            }
        }
        return $data;
    }

    public static function gradePoint($allocatedCourse, $code)
    {
        $data = '-';
        if (!is_array($allocatedCourse)) {
            return $data;
        }
        foreach ($allocatedCourse as $singleResult) {

            if ($singleResult['code'] == trim($code)) {
                $data = number_format($singleResult['marks']['grade_point'], 2) ?? '-';
                break;
            }
        }
        return $data;
    }


    public static function markCheck($allocatedCourse, $code)
    {
        $data = '';
        if (!is_array($allocatedCourse)) {
            return $data;
        }
        foreach ($allocatedCourse as $singleResult) {

            if ($singleResult['code'] == trim($code)) {
                $data = $singleResult['marks']['course_total'];
                break;
            }
        }
        return $data;
    }
}


