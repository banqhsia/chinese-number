<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use banqhsia\ChineseNumber\ChineseNumber;

class InvocationTest extends TestCase
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

    public function test_currency()
    {
        $this->givenNumber(150);
        $this->target->currency();

        $this->resultShouldBe("新臺幣一百五十元");
    }

    public function test_currency_comma()
    {
        $this->givenNumber(15000);
        $this->target->currency()->comma();

        $this->resultShouldBe("新臺幣一萬，五千元");
    }

    public function test_currency_comma_upper()
    {
        $this->givenNumber(15000);
        $this->target->currency()->comma()->upper();

        $this->resultShouldBe("新臺幣壹萬，伍仟元");
    }

    public function test_upper()
    {
        $this->givenNumber(256070);
        $this->target->upper();

        $this->resultShouldBe("貳拾伍萬陸仟零柒拾");
    }

    public function test_toString_should_get_result_using_static_call()
    {
        $this->target = ChineseNumber::number(150000);
        $this->resultShouldBe("十五萬");
    }

    public function test_toString_should_get_result_using_initialization()
    {
        $this->target = new ChineseNumber(150000);
        $this->resultShouldBe("十五萬");
    }

    /**
     * @testWith ["tw", "十五萬"]
     *           ["hk", "十五萬"]
     *           ["cn", "十五万"]
     */
    public function test_static_call_locale($locale, $expected)
    {
        $this->target = ChineseNumber::number(150000, $locale);
        $this->resultShouldBe($expected);
    }

    /**
     * @testWith ["tw", "十五萬"]
     *           ["hk", "十五萬"]
     *           ["cn", "十五万"]
     */
    public function test_initialization_locale($locale, $expected)
    {
        $this->target = new ChineseNumber(150000, $locale);
        $this->resultShouldBe($expected);
    }
}
