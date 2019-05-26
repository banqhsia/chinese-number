<?php
namespace banqhsia\ChineseNumber\Helpers;

class Helper
{
    /**
     * 將字串依照給定的片段長度，分割成陣列
     *
     * @param string $string
     * @param int $length
     * @return array
     */
    public static function chunk($string, $length = 1)
    {
        return array_map('strrev', str_split(strrev($string), $length));
    }

    /**
     * 將陣列攤平變成字串
     *
     * @param array $array
     * @param string $glue
     * @return string
     */
    public static function flattenToString(array $array, $glue = "")
    {
        return implode($glue, array_filter(array_reverse($array)));
    }
}
