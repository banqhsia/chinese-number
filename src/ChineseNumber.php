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
     * @param int|float $number
     * @param string $locale
     */
    public function __construct($number = 0, $locale = 'tw')
    {
        $this->number = new Number($number);

        // 檢查輸入的數字是否為負數
        if ($this->number->isNegative()) {
            // 去除負號，當作整數分開處理
            $this->minus = true;
            $number = $this->number->getAbsolute();
        }

        $this->integers = new Integers($this->number->getIntegerPart() ?? 0);
        $this->decimals = new Decimals($this->number->getDecimalPart() ?? 0);

        $this->setLocale($locale);
    }

    /**
     * 設定語系
     *
     * @param string $locale
     * @return void
     */
    public static function setLocale($locale)
    {
        Locale::setLocale($locale);
    }

    /**
     * 輸入一個被轉換的新數字
     *
     * @param int $number
     * @param string $locale
     * @return ChinsesNumber
     */
    public static function number($number = 0, $locale = 'tw')
    {
        return new static($number, $locale);
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
            $this->integers->getValue(),
            true,
            ($this->comma) ? $this->delimiter : ""
        );

        $decimals = static::flattenToString($this->decimals->getValue());

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

        $this->integers->case = $this->decimals->case = $this->case;

        return $this;
    }

    /**
     * 轉換為負數結果
     *
     * @return self
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
