<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use banqhsia\ChineseNumber\Number;

class NumberTest extends TestCase
{
    /**
     * @var Number
     */
    private $target;

    public function test_isNegative_should_be_true()
    {
        $this->givenNumber(-100);

        $this->assertTrue($this->target->isNegative());
    }

    public function test_isNegative_should_be_false()
    {
        $this->givenNumber(100);

        $this->assertFalse($this->target->isNegative());
    }

    /**
     * @testWith [105, 105]
     *           [-105, 105]
     */
    public function test_getAbsolute_should_return_absolute_value($given, $expected)
    {
        $this->givenNumber($given);
        $this->assertEquals($expected, $this->target->getAbsolute());
    }

    /**
     * @testWith [105.84, 105]
     *           [-105.84, -105]
     */
    public function test_getInteger_should_return_integer_part($given, $expected)
    {
        $this->givenNumber($given);
        $this->assertEquals($expected, $this->target->getInteger());
    }

    /**
     * @testWith [105.84, 0.84]
     *           [-105.84, -0.84]
     */
    public function test_getInteger_should_return_decimal_part($given, $expected)
    {
        $this->givenNumber($given);
        $this->assertEquals($expected, $this->target->getDecimal());
    }

    public function test_getIntegerAbsolute_should_get_integer_part_and_is_positive()
    {
        $this->givenNumber(-105.84);

        $this->assertEquals(105, $this->target->getIntegerAbsolute());
    }

    public function test_getDecimalAbsolute_should_get_decimal_part_and_is_positive()
    {
        $this->givenNumber(-105.84);

        $this->assertEquals(0.84, $this->target->getDecimalAbsolute());
    }

    /**
     * @testWith [105.84, 105]
     *           [-105.84, 105]
     */
    public function test_getIntegerPart_should_get_part_of_integer($given, $expected)
    {
        $this->givenNumber($given);
        $this->assertEquals($expected, $this->target->getIntegerPart());
    }

    /**
     * @testWith [105.84, 84]
     *           [-105.84, 84]
     */
    public function test_getDecimalPart_should_get_part_of_decimal($given, $expected)
    {
        $this->givenNumber($given);

        $this->assertEquals($expected, $this->target->getDecimalPart());
    }

    private function givenNumber($number)
    {
        $this->target = new Number($number);
    }

    public function tearDown()
    {
        unset($this->target);
    }

}
