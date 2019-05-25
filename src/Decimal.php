<?php

namespace banqhsia\ChineseNumber;

class Decimal
{
    public function __construct($decimal)
    {
        $this->decimal = $decimal;
    }

    public function getDecimal()
    {
        return $this->decimal;
    }

    public function isZero()
    {
        return 0 === $this->decimal;
    }
}
