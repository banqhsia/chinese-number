<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use banqhsia\ChineseNumber\ChineseNumber;

class ChineseNumberTest extends TestCase
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

    public function test_105_should_get_一百○五()
    {
        $this->givenNumber(105);
        $this->resultShouldBe('一百○五');
    }

    public function test_200_should_get_二百()
    {
        $this->givenNumber(200);
        $this->resultShouldBe('二百');
    }

    public function test_minus_200_should_get_負二百()
    {
        $this->givenNumber(-200);
        $this->resultShouldBe('負二百');
    }

    public function test_2050_should_get_二千○五十()
    {
        $this->givenNumber(2050);
        $this->resultShouldBe('二千○五十');
    }

    public function test_2056_should_get_二千○五十六()
    {
        $this->givenNumber(2056);
        $this->resultShouldBe('二千○五十六');
    }

    public function test_2500_should_get_二千五百()
    {
        $this->givenNumber(2500);
        $this->resultShouldBe('二千五百');
    }

    public function test_10000_should_get_一萬()
    {
        $this->givenNumber(10000);
        $this->resultShouldBe('一萬');
    }

    public function test_10005_should_get_一萬零五()
    {
        $this->givenNumber(10005);
        $this->resultShouldBe('一萬○五');
    }

    public function test_10090_should_get_一萬零九十()
    {
        $this->givenNumber(10090);
        $this->resultShouldBe('一萬○九十');
    }

    public function test_10900_should_get_一萬零九百()
    {
        $this->givenNumber(10900);
        $this->resultShouldBe('一萬○九百');
    }

    public function test_19000_should_get_一萬九千()
    {
        $this->givenNumber(19000);
        $this->resultShouldBe('一萬九千');
    }

    public function test_19005_should_get_一萬九千○五()
    {
        $this->givenNumber(19005);
        $this->resultShouldBe('一萬九千○五');
    }

    public function test_19050_should_get_一萬九千○五十()
    {
        $this->givenNumber(19050);
        $this->resultShouldBe('一萬九千○五十');
    }

    public function test_19500_should_get_一萬九千五百()
    {
        $this->givenNumber(19500);
        $this->resultShouldBe('一萬九千五百');
    }

    public function test_19503_should_get_一萬九千五百○三()
    {
        $this->givenNumber(19503);
        $this->resultShouldBe('一萬九千五百○三');
    }

    public function test_19530_should_get_一萬九千五十三()
    {
        $this->givenNumber(19530);
        $this->resultShouldBe('一萬九千五百三十');
    }

    public function test_19532_should_get_一萬九千五十三二()
    {
        $this->givenNumber(19532);
        $this->resultShouldBe('一萬九千五百三十二');
    }

    public function tesrDown()
    {
        unset($this->target);
        unset($this->actual);
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
