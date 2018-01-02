<?php
namespace banqhsia\ChineseNumber\Types;

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
                    : static::$numbers[$this->case][$num].static::$thousand[$this->case][$j]
                ;

                $thousand[] = $proceed;

            }

            $result[] = (function() use ($thousand, $i){

                $thousand = static::flattenToString($thousand);
                $thousand = preg_replace('/(\*+).?$/', "", $thousand);

                return ($thousand) ? $thousand.static::$systems[$i] : NULL;

            })();

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
            return [static::$numbers[$this->case][0]];
        }

        return $this->handler();

    }

}
