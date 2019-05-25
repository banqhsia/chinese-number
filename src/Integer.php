<?php

namespace banqhsia\ChineseNumber;

class Integer
{
    public function __construct($integer)
    {
        $this->integer = $integer;
    }

    public function getInteger()
    {
        return $this->integer;
    }

    public function isZero()
    {
        return 0 === $this->integer;
    }
}
