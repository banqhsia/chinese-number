<?php
namespace banqhsia\ChineseNumber\Types;

class Decimals extends Numbers
{

    /**
     * Construct
     *
     * @param integer $number
     */
    public function __construct($number = 0)
    {
        $this->input = $number;
    }


    /**
     * 處理小數轉換
     *
     * @return $result 轉換為中文數字的結果
     */
    public function handler()
    {

        // 將字串按照給定的長度切割為陣列
        $chunked = static::chunk($this->input, 1);

        $result = [];
        foreach ($chunked as $i => $set) {
            $result[] = static::$numbers[$this->case][$set];
        }

        return $result;
    }

    /**
     * 取得結果值
     */
    public function getValue()
    {

        // 輸入的數字為零，不處理
        if ( static::isZero($this->input) ) {
            return [];
        }

        return $this->handler();

    }

}