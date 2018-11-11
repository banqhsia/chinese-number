<?php
namespace banqhsia\ChineseNumber;

use banqhsia\ChineseNumber\Locale\Locale;
use banqhsia\ChineseNumber\Helpers\Helper;
use banqhsia\ChineseNumber\Types\Decimals;
use banqhsia\ChineseNumber\Types\Integers;

class ChineseNumber
{
    use Helper;

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
     * 是否以大寫數字進行轉換
     *
     * @var integer
     */
    protected $case = 0;

    /**
     * Construct
     *
     * @param integer $number
     */
    public function __construct($number = 0, $locale = 'tw')
    {
        $this->parseNumber(floatval($number));

        $this->setLocale($locale);
    }

    /**
     * 設定語系
     *
     * @param string $value
     */
    public static function setLocale($locale)
    {
        return Locale::setLocale($locale);
    }

    /**
     * 輸入一個被轉換的新數字
     *
     * @param integer $number
     * @return ChineseNumber
     */
    public static function number($number = 0, $locale = 'tw')
    {
        return new ChineseNumber($number, $locale);
    }

    /**
     * 解析數字是否為負數
     *
     * @param float $number
     * @return void
     */
    protected function parseNumber(float $number)
    {
        $numberObj = new Number($number);

        // 檢查輸入的數字是否為負數
        if ($numberObj->isNegative()) {
            // 去除負號，當作整數分開處理
            $this->minus = true;
            $number = $numberObj->getAbsolute();
        }

        $this->Integers = new Integers($numberObj->getIntegerPart() ?? 0);
        $this->Decimals = new Decimals($numberObj->getDecimalPart() ?? 0);
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

        $integers = static::flattenToString(
            $this->Integers->getValue(),
            true,
            ($this->comma) ? $this->delimiter : ""
        );

        $decimals = static::flattenToString($this->Decimals->getValue());

        $result = (function () use ($integers, $decimals) {

            $result = $integers . ($decimals ? Locale::dot() . $decimals : null);

            return $this->trim($result);
        })();

        // 負數模式
        if ($this->minus) {
            $result = Locale::minus() . $result;
        }

        // 貨幣模式
        if ($this->currency) {
            $result = $this->currency_units['prepend'] . $result . $this->currency_units['append'];
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
    public function comma(string $delimiter = null)
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
            'prepend' => ($prepend) ? $prepend : Locale::currency_units()['prepend'],
            'append' => ($append) ? $append : Locale::currency_units()['append'],
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
        $this->case = 1;

        $this->Integers->case = $this->Decimals->case = $this->case;

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
     * 去除零碎事項
     *
     * 如 「一十五」變為「十五」
     *
     * @param string $string
     * @return $string 處理過的字串
     */
    public function trim($string)
    {

        $string = preg_replace('/(\*+)$/m', "", $string);
        $string = preg_replace('/\*+/', Locale::numbers()[$this->case][0], $string);

        $string = preg_replace((function () {

            $tens = Locale::numbers()[$this->case][1];
            $ones = Locale::thousand()[$this->case][1];

            return "/^($tens)($ones)(.{1})?/";
        })(), "$2$3", $string);

        return $string;
    }

    /**
     * 傳回 render() 的結果
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
