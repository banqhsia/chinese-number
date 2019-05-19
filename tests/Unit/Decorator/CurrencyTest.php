<?php

namespace Tests\Unit\Decorator;

use PHPUnit\Framework\TestCase;
use Tests\Unit\AssertionHelper;
use banqhsia\ChineseNumber\ChineseNumber;

class CurrencyTest extends TestCase
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
     * @testWith ["tw", "150", "新臺幣一百五十元"]
     *           ["tw", "150000", "新臺幣十五萬元"]
     *           ["tw", "150000000", "新臺幣一億五千萬元"]
     *
     *           ["hk", "150", "港幣一百五十元"]
     *           ["hk", "150000", "港幣十五萬元"]
     *           ["hk", "150000000", "港幣一億五千萬元"]
     *
     *           ["cn", "150", "人民币一百五十元"]
     *           ["cn", "150000", "人民币十五万元"]
     *           ["cn", "150000000", "人民币一亿五千万元"]
     */
    public function test_should_get_localed_currency($locale, $given, $expected)
    {
        $this->givenNumber($given);

        $this->target->setLocale($locale);
        $this->target->currency();

        $this->resultShouldBe($expected);
    }

    public function test_should_allow_using_custom_prepend_and_append()
    {
        $this->givenNumber(150);

        $this->target->currency('美金', '元');

        $this->resultShouldBe('美金一百五十元');
    }
}
