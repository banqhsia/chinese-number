<?php

namespace banqhsia\ChineseNumber;

class Number
{
    /**
     * Construct
     *
     * @param float $number
     */
    public function __construct($number)
    {
        $this->number = $number;
    }

    /**
     * 是否為負數
     *
     * @return bool
     */
    public function isNegative()
    {
        return $this->number < 0;
    }

    /**
     * 取得絕對值
     *
     * @return float
     */
    public function getAbsolute()
    {
        return abs($this->number);
    }

    /**
     * 取得整數部分
     *
     * @return int
     */
    public function getInteger()
    {
        return (int) $this->number;
    }

    /**
     * 取得小數部分
     *
     * @return float
     */
    public function getDecimal()
    {
        return $this->number - $this->getInteger();
    }

    /**
     * 取得整數部分絕對值
     *
     * @return int
     */
    public function getIntegerAbsolute()
    {
        return (int) ($this->getAbsolute());
    }

    /**
     * 取得小數部分絕對值
     *
     * @return float
     */
    public function getDecimalAbsolute()
    {
        return $this->getAbsolute() - $this->getIntegerAbsolute();
    }

    /**
     * 取得整數部分 (注意，是去除正負號的整數部分，例如 -105.84 會傳回 105)
     *
     * @return int
     */
    public function getIntegerPart()
    {
        preg_match("/(\d+)\.?(\d+)?/", $this->number, $matches);

        return (int) $matches[1];
    }

    /**
     * 取得小數部分 (注意，是去除正負號及 0. 的小數部分，例如 -105.84 會傳回 84)
     *
     * @return int
     */
    public function getDecimalPart()
    {
        preg_match("/(\d+)\.?(\d+)?/", $this->number, $matches);

        return (int) $matches[2];
    }
}
