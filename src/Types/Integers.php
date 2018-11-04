<?php
namespace banqhsia\ChineseNumber\Types;

use banqhsia\ChineseNumber\Locale\Locale;

class Integers extends Numbers
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
     * 處理整數轉換
     *
     * @return string $result 轉換為中文數字的結果
     */
    public function handler()
    {

        // 將字串按照給定的長度切割為陣列
        $chunked = static::chunk($this->input, 4);

        foreach ($chunked as $i => $set) {
            $set_chunked = static::chunk($set, 1);

            $thousand = [];
            foreach ($set_chunked as $j => $num) {
                // 如果該位數為「0」，則註記 「*」
                $proceed = ( $num == 0 ) ? "*"
                    : Locale::numbers()[$this->case][$num] . Locale::thousand()[$this->case][$j]
                ;

                $thousand[] = $proceed;
            }

            $result[] = (function () use ($thousand, $i) {

                $thousand = static::flattenToString($thousand);
                $thousand = preg_replace('/(\*+).?$/', "", $thousand);

                return ($thousand) ? $thousand . Locale::systems()[$i] : null;
            })();
        }

        return $result;
    }

    /**
     * 取得結果字串
     *
     * @return mixed
     */
    public function getValue()
    {

        // 輸入的數字為零，不處理
        if (static::isZero($this->input)) {
            return [Locale::numbers()[$this->case][0]];
        }

        return $this->handler();
    }
}
