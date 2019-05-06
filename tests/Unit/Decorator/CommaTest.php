<?php

namespace Tests\Unit\Decorator;

use PHPUnit\Framework\TestCase;
use Tests\Unit\AssertionHelper;
use banqhsia\ChineseNumber\ChineseNumber;

class CommaTest extends TestCase
{
    use AssertionHelper;

    /**
     * @var ChineseNumber
     */
    private $target;

    public function setUp()
    {
        $this->target = new ChineseNumber;
    }

    /**
     * @testWith [15000, "一萬，五千"]
     *           [20000, "二萬"]
     *           [205000, "二十萬，五千"]
     *           [205060, "二十萬，五千○六十"]
     *           [150005000, "一億，五千萬，五千"]
     */
    public function test_should_seperate_result_by_comma($given, $expected)
    {
        $this->givenNumber($given);
        $this->target->comma();
        $this->resultShouldBe($expected);
    }

    /**
     * @testWith [15000, "一萬,五千"]
     *           [20000, "二萬"]
     *           [205000, "二十萬,五千"]
     *           [205060, "二十萬,五千○六十"]
     *           [150005000, "一億,五千萬,五千"]
     */
    public function test_should_seperate_result_by_custom_comma($given, $expected)
    {
        $this->givenNumber($given);
        $this->target->comma(',');
        $this->resultShouldBe($expected);
    }
}
