<?php

namespace banqhsia\ChineseNumber\Locale;

interface LocaleInterface
{
    public function getCurrencyPrepend();
    public function getCurrencyAppend();

    public function getNumber($number);
    public function getSystem($system);
    public function getThousand($thousand);
    public function getMinus();
    public function getDot();
}
