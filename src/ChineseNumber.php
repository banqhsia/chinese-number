<?php
namespace banqhsia\ChineseNumber;

use banqhsia\ChineseNumber\Helpers\Helper;
use banqhsia\ChineseNumber\Types\Decimals;
use banqhsia\ChineseNumber\Types\Integers;
use banqhsia\ChineseNumber\Locale\LocaleFactory;
use banqhsia\ChineseNumber\Locale\LocaleInterface;

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
     * @var LocaleInterface
     */
    private $locale;

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

        $this->locale = LocaleFactory::createLocale($locale);

        $this->integers = new Integers($this->number, $this->locale);
        $this->decimals = new Decimals($this->number, $this->locale);

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
        LocaleFactory::createLocale($locale);
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
    public function render()
    {

        $integers = static::flattenToString(
            $this->integers->getValue(),
            true,
            ($this->comma) ? $this->delimiter : ""
        );

        $decimals = static::flattenToString($this->decimals->getValue());

        $result = (function () use ($integers, $decimals) {
            $result = $integers . ($decimals ? $this->locale->getDot() . $decimals : null);

            return $this->trim($result);
        })();

        // 負數模式
        if ($this->minus) {
            $result = "{$this->locale->getMinus()}$result";
        }

        // 貨幣模式
        if ($this->currency) {
            $result = "{$this->currencyUnits['prepend']}{$result}{$this->currencyUnits['append']}";
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
    public function currency($prepend = null, $append = null)
    {
        $this->currency = true;

        $this->currencyUnits = [
            'prepend' => ($prepend) ?: $this->locale->getCurrencyPrepend(),
            'append' => ($append) ?: $this->locale->getCurrencyAppend(),
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
        $string = preg_replace('/\*+/', $this->locale::$numbers[$this->case][0], $string);

        $string = preg_replace((function () {

            $tens = $this->locale::$numbers[$this->case][1];
            $ones = $this->locale::$thousand[$this->case][1];

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
