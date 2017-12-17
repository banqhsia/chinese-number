<?
namespace banqhsia\ChineseNumber\Helpers;

class Helper
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
     */
    public static function isNegative($number)
    {
        return $number < 0;
    }

    /**
     * 將陣列攤平變成字串
     **/
    public static function flattenToString(Array $array, $reverse = true, $glue = "")
    {
        $array = ($reverse) ? array_reverse($array) : $array;

        $flattened = implode($glue, array_filter($array));

        return $flattened;
    }

    /**
     * Trim
     */
    // public static function trimTen($string)
    // {
    //     return preg_replace("/一十(.{1})/", "十$1", $string);
    // }

    public static function isBetween($input, $from, $to)
    {
        return ($input >= $from && $input <= $to);
    }

    public static function trim($string)
    {

        $string = preg_replace('/(\*+)$/m', "", $string);
        $string = preg_replace('/\*+/', "零", $string);

        $string = preg_replace("/^一十(.{1})?/", "十$1", $string);

        return $string;
    }

}


