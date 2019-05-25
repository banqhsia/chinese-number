<?php
namespace banqhsia\ChineseNumber\Types;

use banqhsia\ChineseNumber\Number;
use banqhsia\ChineseNumber\Locale\LocaleInterface;

class Decimals extends Numbers
{
    /**
     * @var Number
     */
    private $number;

    /**
     * @var LocaleInterface
     */
    private $locale;

    /**
     * Construct
     *
     * @param integer $number
     */
    public function __construct(Number $number, LocaleInterface $locale)
    {
        $this->number = $number;
        $this->locale = $locale;
    }

    /**
     * 處理小數轉換
     *
     * @return string $result 轉換為中文數字的結果
     */
    public function handler()
    {

        // 將字串按照給定的長度切割為陣列
        $chunked = static::chunk($this->number->getDecimalPart(), 1);

        $result = [];
        foreach ($chunked as $i => $set) {
            $result[] = $this->locale->getNumber($set);
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
        if (static::isZero($this->number->getDecimalPart())) {
            return [];
        }

        return $this->handler();
    }
}
