<?php

namespace Tests\Unit\Decorator;

use PHPUnit\Framework\TestCase;
use Tests\Unit\AssertionHelper;
use banqhsia\ChineseNumber\ChineseNumber;

class MinusTest extends TestCase
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
     * @testWith ["tw", "150", "負一百五十"]
     *           ["tw", "150000", "負十五萬"]
     *
     *           ["hk", "150", "負一百五十"]
     *           ["hk", "150000", "負十五萬"]
     *
     *           ["cn", "150", "负一百五十"]
     *           ["cn", "150000", "负十五萬"]
     */
    public function test_should_get_value_with_minus($locale, $given, $expected)
    {
        $this->givenNumber($given);

        $this->target->setLocale($locale);
        $this->target->minus();

        $this->resultShouldBe($expected);
    }
}
