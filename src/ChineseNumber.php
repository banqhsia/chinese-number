<?php
namespace banqhsia\ChineseNumber;

use banqhsia\ChineseNumber\Types\Integers;
use banqhsia\ChineseNumber\Types\Decimals;
use banqhsia\ChineseNumber\Types\Numbers;

use banqhsia\ChineseNumber\Helpers\Helper;

class ChineseNumber
{

    public function __construct($number = 0)
    {

        $this->numbers = new Numbers( floatval($number) );

    }

    /**
     * 輸入一個被轉換的新數字
     *
     * @param integer $number
     * @return ChineseNumber
     */
    public static function number($number = 0)
    {
        return new ChineseNumber($number);
    }


    /**
     * 包裝呼叫 Number 類別的方法
     *
     * @param $func
     * @param $args
     * @return $this->number (Number 的 instance)
     */
    public function __call($method, $args)
    {
        $this->numbers->{$method}(...$args);
        return $this->numbers;

    }

    public function __toString()
    {
        return $this->numbers->__toString();
    }
}