<?php

namespace banqhsia\ChineseNumber\Locale;

class Locale implements LocaleInterface
{

    private $case = 0;

    public function setCase($case)
    {
        $this->case = $case;

        return $this;
    }

    public function getCurrencyPrepend()
    {
        return static::$currency_units['prepend'];
    }

    public function getCurrencyAppend()
    {
        return static::$currency_units['append'];
    }

    public function getNumber($number)
    {
        return static::$numbers[$this->case][$number];
    }

    public function getSystem($system)
    {
        return static::$systems[$system];
    }

    public function getThousand($thousand)
    {
        return static::$thousand[$this->case][$thousand];
    }

    public function getMinus()
    {
        return static::$minus;
    }

    public function getDot()
    {
        return static::$dot;
    }
}
