<?php
namespace banqhsia\ChineseNumber\Types;

use banqhsia\ChineseNumber\Helpers\Helper;

class Decimals extends Numbers
{

    /**
     * Construct
     *
     * @param integer $number
     */
    public function __construct($number = 0)
    {
        $this->input = $number;
    }


    public function handler()
    {
        return "";
    }

}