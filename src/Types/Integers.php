<?php
namespace banqhsia\ChineseNumber\Types;

use banqhsia\ChineseNumber\Helpers\Helper;

class Integers
{

    /**
     * 輸入的數字
     *
     * @var integer
     */
    protected $input = 0;

    /**
     * 數字是否帶有正負號
     *
     * @var boolean
     */
    protected $minus = false;

    /**
     * 是否以大寫數字進行轉換
     *
     * @var boolean
     */
    protected $upper = false;

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
     * 大小寫數字們
     */
    static $numbers = [
        'lower' => ['零', '一', '二', '三', '四', '五', '六', '七', '八', '九'],
        'upper' => ['零', '壹', '貳', '參', '肆', '伍', '陸', '柒', '捌', '玖']
    ];

    /**
     * 每個千單位的數字們
     */
    static $thousand = [
        'lower' => ['', '十', '百', '千'],
        'upper' => ['', '拾', '佰', '仟']
    ];

    /**
     * 數字系統
     */
    static $systems = ['', '萬', '億', '兆', '京', '垓', '秭', '壤', '溝', '澗', '正', '載'];

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
     * 處理數字轉換
     *
     * @return $result 轉換為中文數字的結果
     */
    private function handler()
    {

        $number = $this->input;

        $case = ( $this->upper ) ? "upper" : "lower";

        // 輸入的數字為零，不處理
        if ($number == 0) {

            // TODO: 依照各語言顯示 0
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
                    : static::$numbers[$case][$num].static::$thousand[$case][$j]
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

    /**
     * 加入位數間隔
     *
     * 每「四位」加入一個間隔
     *
     * @param boolean $delimiter
     * @return $this
     */
    public function comma($delimiter = false)
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
    public function currency($prepend = "", $append = "")
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
        $this->upper = true;
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

    /**
     * 輸出結果
     *
     * 將已經轉換完的數字陣列，依照要求進行修飾（如負數、貨幣樣式等）
     *
     * @return $result 轉換的結果
     */
    private function render()
    {

        $result = Helper::flattenToString(
            $this->handler(),
            true,
            ($this->comma) ? $this->delimiter : ""
        );

        $result = Helper::trim( $result );

        // 負數模式
        if ( $this->minus ) {
            $result = "負".$result;
        }

        // 貨幣模式
        if ( $this->currency ) {
            $result = $this->currency_units['prepend'].$result.$this->currency_units['append'];
        }

        return $result;

    }

    public function __toString()
    {
        return $this->render();
    }

}
