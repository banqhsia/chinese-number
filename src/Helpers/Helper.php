<?php
namespace banqhsia\ChineseNumber\Helpers;

trait Helper
{

    /**
     * 將字串依照給定的片段長度，分割成陣列
     *
     * PHP 預設的切割是從左開始，所以必須先將文字全部反轉再切割
     */
    public static function chunk($string, $length = 1, $reverse = false)
    {

        $chunked = array_map('strrev', str_split(strrev($string), $length));

        return ($reverse) ? array_reverse($chunked) : $chunked;
    }

    /**
     * 檢查給定的數字是否小於零（負數）
     *
     * @param integer $number
     * @return boolean
     */
    public static function isNegative($number)
    {
        return $number < 0;
    }

    /**
     * 攤平陣列
     *
     * 將轉換完成的陣列攤平變成字串
     *
     * @param array $array
     * @param boolean $reverse
     * @param string $glue
     * @return $flattened 已變成字串的轉換結果
     */
    public static function flattenToString(Array $array, $reverse = true, $glue = "")
    {
        $array = ($reverse) ? array_reverse($array) : $array;

        $flattened = implode($glue, array_filter($array));

        return $flattened;
    }

    /**
     * 檢測數字是否介於某一範圍
     *
     * @param integer $input
     * @param integer $from
     * @param integer $to
     * @return boolean
     */
    public static function isBetween($input, $from, $to)
    {
        return ($input >= $from && $input <= $to);
    }

    /**
     * 是否為零
     *
     * @param integer $number
     * @return boolean
     */
    public static function isZero($number = 0)
    {
        return ($number == 0);
    }

}


