<?php

namespace banqhsia\ChineseNumber;

use banqhsia\ChineseNumber\Helpers\Helper;

class Decimal
{
    use Helper;

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

    public function chunked()
    {
        return static::chunk($this->getDecimal(), 1);
    }
}
