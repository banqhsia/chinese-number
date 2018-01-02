<?php
namespace banqhsia\ChineseNumber;

use banqhsia\ChineseNumber\Types\Integers;
use banqhsia\ChineseNumber\Types\Decimals;

use banqhsia\ChineseNumber\Helpers\Helper;

class ChineseNumber
{

    /**
     * 分割出的數字
     *
     * @var array
     */
    protected $numbers = [];

    /**
     * 數字是否帶有正負號
     *
     * @var boolean
     */
    protected $minus = false;

    /**
     * 是否將結果轉換為貨幣的顯示方式
     *
     * @var boolean
     */
    protected $currency = false;

    /**
     * 轉換結果是否進行分位
     *
     * @var boolean
     */
    protected $comma = false;

    /**
     * 分割字元
     *
     * @var string
     */
    protected $delimiter = "，";

    /**
     * 貨幣格式的前輟、後輟
     *
     * @var array
     */
    protected $currency_units = [
        'prepend' => '新臺幣',
        'append' => '元'
    ];

    /**
     * Construct
     *
     * @param integer $number
     */
    public function __construct($number = 0)
    {
        $this->parseNumber(floatval($number));
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
     * 解析數字是否為負數
     *
     * @param float $number
     * @return void
     */
    protected function parseNumber(float $number)
    {

        // 檢查輸入的數字是否為負數
        if ( Helper::isNegative($number) ) {

            // 去除負號，當作整數分開處理
            $this->minus = true;
            $number = abs( $number );
        }

        // 依照小數點將數字切割為兩部分
        preg_match("/(\d+)\.?(\d+)?/", $number, $this->numbers);

        $this->Integers = new Integers($this->numbers[1] ?? 0);
        $this->Decimals = new Decimals($this->numbers[2] ?? 0);

    }

    /**
     * 輸出結果
     *
     * 將已經轉換完的數字陣列，依照要求進行修飾（如負數、貨幣樣式等）
     *
     * @return $result 轉換的結果
     */
    protected function render()
    {

        $integers = Helper::flattenToString(
            $this->Integers->getValue(),
            true,
            ($this->comma) ? $this->delimiter : ""
        );

        $decimals = Helper::flattenToString( $this->Decimals->getValue() );

        $result = (function() use ($integers, $decimals) {

            $result = $integers.($decimals ? "點" .$decimals: NULL);

            return Helper::trim( $result );

        })();

        // 負數模式
        if ( $this->minus && $this->numbers[0] ) {
            $result = "負".$result;
        }

        // 貨幣模式
        if ( $this->currency ) {
            $result = $this->currency_units['prepend'].$result.$this->currency_units['append'];
        }

        return $result;

    }


    /**
     * 加入位數間隔
     *
     * 每「四位」加入一個間隔
     *
     * @param string $delimiter
     * @return $this
     */
    public function comma(string $delimiter = NULL)
    {

        $this->comma = true;

        $this->delimiter = ($delimiter) ? $delimiter : $this->delimiter;

        return $this;
    }

    /**
     * 設定為貨幣模式
     *
     * @param string $prepend
     * @param string $append
     * @return $this
     */
    public function currency(string $prepend = "", string $append = "")
    {

        $this->currency = true;

        $this->currency_units = [
            'prepend' => ($prepend) ? $prepend : $this->currency_units['prepend'],
            'append' => ($append) ? $append : $this->currency_units['append'],
        ];

        return $this;
    }

    /**
     * 大寫數字
     *
     * @return $this
     */
    public function upper()
    {
        $this->Integers->case = $this->Decimals->case = true;

        return $this;
    }

    /**
     * 轉換為負數結果
     *
     * @return void
     */
    public function minus()
    {
        $this->minus = true;

        return $this;
    }


    public function __toString()
    {
        return $this->render();
    }
}