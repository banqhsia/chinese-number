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
     * 攤平陣列
     *
     * 將轉換完成的陣列攤平變成字串
     *
     * @param array $array
     * @param boolean $reverse
     * @param string $glue
     * @return $flattened 已變成字串的轉換結果
     */
    public static function flattenToString(array $array, $reverse = true, $glue = "")
    {
        $array = ($reverse) ? array_reverse($array) : $array;

        $flattened = implode($glue, array_filter($array));

        return $flattened;
    }

    /**
     * 是否為零
     *
     * @param integer $number
     * @return boolean
     */
    public static function isZero($number = 0)
    {
        return (0 == $number);
    }
}
