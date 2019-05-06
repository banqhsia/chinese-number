<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use banqhsia\ChineseNumber\ChineseNumber;

class PositiveNumberTest extends TestCase
{
    /**
     * @var ChineseNumber
     */
    private $target;

    public function setUp()
    {
        $this->target = new ChineseNumber;
    }

    public function test_number_should_get_ChineseNumber()
    {
        $actual = $this->target->number(12345);
        $this->assertInstanceOf(ChineseNumber::class, $actual);
    }

    /**
     * @testWith [105, "一百○五"]
     *           [200, "二百"]
     *           [-200, "負二百"]
     *           [2050, "二千○五十"]
     *           [2056, "二千○五十六"]
     *           [2500, "二千五百"]
     *           [10000, "一萬"]
     *           [10005, "一萬○五"]
     *           [10090, "一萬○九十"]
     *           [10900, "一萬○九百"]
     *           [19000, "一萬九千"]
     *           [19005, "一萬九千○五"]
     *           [19050, "一萬九千○五十"]
     *           [19500, "一萬九千五百"]
     *           [19503, "一萬九千五百○三"]
     *           [19530, "一萬九千五百三十"]
     *           [19532, "一萬九千五百三十二"]
     */
    public function test_positive_number($given, $expected)
    {
        $this->givenNumber($given);
        $this->resultShouldBe($expected);
    }

    private function givenNumber($number)
    {
        $this->actual = (string) $this->target->number($number);
    }

    private function resultShouldBe($expected)
    {
        $this->assertEquals($expected, $this->actual);
    }
}
