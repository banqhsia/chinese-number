<?php
namespace banqhsia\ChineseNumber\Helpers;

trait Helper
{
    /**
     * 將字串依照給定的片段長度，分割成陣列
     *
     * PHP 預設的切割是從左開始，所以必須先將文字全部反轉再切割
     */
    public static function chunk($string, $length = 1)
    {
        return array_map('strrev', str_split(strrev($string), $length));
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
    public static function flattenToString(array $array, $glue = "")
    {
        return implode($glue, array_filter(array_reverse($array)));
    }
}
