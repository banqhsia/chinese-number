<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use banqhsia\ChineseNumber\ChineseNumber;

class DecimalsTest extends TestCase
{
    /**
     * @var ChineseNumber
     */
    private $target;

    public function setUp()
    {
        $this->target = new ChineseNumber;
    }

    public function test_minus_105_should_get_負一百○五點三三()
    {
        $this->givenNumber(-105.33);
        $this->resultShouldBe('負一百○五點三三');
    }

    public function test_105_should_get_一百○五點三三()
    {
        $this->givenNumber(105.33);
        $this->resultShouldBe('一百○五點三三');
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
