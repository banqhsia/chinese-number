<?php
namespace banqhsia\ChineseNumber\Types;

use banqhsia\ChineseNumber\Number;
use banqhsia\ChineseNumber\Integer;
use banqhsia\ChineseNumber\Locale\Locale;
use banqhsia\ChineseNumber\Locale\LocaleInterface;

class Integers extends Numbers
{
    /**
     * @var Integer
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
        $this->number = $number->getIntegerObject();
        $this->locale = $locale;
    }

    /**
     * 處理整數轉換
     *
     * @return string $result 轉換為中文數字的結果
     */
    public function handler()
    {
        $this->locale->setCase($this->case);

        // 將字串按照給定的長度切割為陣列
        $chunked = static::chunk($this->number->getInteger(), 4);

        foreach ($chunked as $i => $set) {
            $set_chunked = static::chunk($set, 1);

            $thousand = [];
            foreach ($set_chunked as $j => $num) {
                // 如果該位數為「0」，則註記 「*」
                $proceed = (0 == $num) ? "*"
                : "{$this->locale->getNumber($num)}{$this->locale->getThousand($j)}"
                ;

                $thousand[] = $proceed;
            }

            $result[] = (function () use ($thousand, $i) {

                $thousand = static::flattenToString($thousand);
                $thousand = preg_replace('/(\*+).?$/', "", $thousand);

                return ($thousand) ? "$thousand{$this->locale->getSystem($i)}" : null;
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
        if ($this->number->isZero()) {
            // TODO: deal with that
            return $this->number->getNumber(0);
        }

        return $this->handler();
    }
}
