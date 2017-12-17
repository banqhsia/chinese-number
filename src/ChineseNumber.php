<?php
namespace banqhsia\ChineseNumber;

use banqhsia\ChineseNumber\Helpers\Helper;

class ChineseNumber
{

    public $input = 0;

    public $minus = false;

    public $delimiter = "";

    protected $currency_units = [];

    protected static $numbers = ['零', '一', '二', '三', '四', '五', '六', '七', '八', '九'];

    protected static $thousand = ['', '十', '百', '千'];

    protected static $systems = ['', '萬', '億', '兆', '京', '垓', '秭'];


    public function __construct($number = 0)
    {
        $this->input = $number;
    }

    public static function number($number = 0)
    {
        return new ChineseNumber($number);
    }

    public function comma($delimiter = "，")
    {

        $this->delimiter = $delimiter;

        return $this;
    }

    public function currency($prepend = "新臺幣", $append = "元")
    {

        // dd(static::$currency_units);
        $this->currency_units = [
            'prepend' => $prepend,
            'append' => $append,
        ];

        return $this;
    }


    private function handler()
    {

        $number = $this->input;

        // 輸入的數字為零，不處理
        if ($number == 0) {
            return ["零"];
        }

        // 檢查輸入的數字是否為負數
        if ( Helper::isNegative($number) ) {
            // 去除負號，當作整數分開處理
            $this->minus = true;
            $number = abs( $number );
        }

        // 將字串按照給定的長度切割為陣列
        $chunked = Helper::chunk($number, 4);

        foreach ($chunked as $i => $set) {

            $set_chunked = Helper::chunk($set, 1);

            $thousand = [];
            foreach ($set_chunked as $j => $num) {

                // 如果該位數為「0」，則註記 「*」
                $proceed = ( $num == 0 ) ? "*"
                    : static::$numbers[$num].static::$thousand[$j]
                ;

                $thousand[] = $proceed;

            }

            $result[] = (function() use ($thousand, $i){

                $thousand = Helper::flattenToString($thousand);
                $thousand = preg_replace('/(\*+).?$/', "", $thousand);

                return ($thousand) ? $thousand.static::$systems[$i] : "";

            })();

        }

        return $result;
    }


    public function minus()
    {
        $this->minus = true;
        return $this;
    }


    private function render()
    {

        $result = Helper::flattenToString( $this->handler() , true, $this->delimiter );

        $result = Helper::trim( $result );


        if ( $this->minus ) {
            $result = "負".$result;
        }
        else {

            if ( $this->currency_units ) {
                $result = $this->currency_units['prepend'].$result.$this->currency_units['append'];
            }

        }


        return $result;

    }

    public function __toString()
    {
        return $this->render();
    }

}
