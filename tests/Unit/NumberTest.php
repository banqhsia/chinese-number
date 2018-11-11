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

    public function test_getAbsolute_should_return_absolute_value_when_positive()
    {
        $this->givenNumber(105);

        $this->assertEquals(105, $this->target->getAbsolute());
    }

    public function test_getAbsolute_should_return_absolute_value_when_negative()
    {
        $this->givenNumber(-105);

        $this->assertEquals(105, $this->target->getAbsolute());
    }

    public function test_getInteger_should_return_integer_part_when_positive()
    {
        $this->givenNumber(105.84);

        $this->assertEquals(105, $this->target->getInteger());
    }

    public function test_getInteger_should_return_integer_part_when_negative()
    {
        $this->givenNumber(-105.84);

        $this->assertEquals(-105, $this->target->getInteger());
    }

    public function test_getDecimal_should_return_decimal_part_when_positive()
    {
        $this->givenNumber(105.84);

        $this->assertEquals(0.84, $this->target->getDecimal());
    }

    public function test_getDecimal_should_return_decimal_part_when_negative()
    {
        $this->givenNumber(-105.84);

        $this->assertEquals(-0.84, $this->target->getDecimal());
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

    public function test_getIntegerPart_should_get_part_of_integer()
    {
        $this->givenNumber(105.84);

        $this->assertEquals(105, $this->target->getIntegerPart());
    }

    public function test_getIntegerPart_should_get_part_of_integer_when_negative()
    {
        $this->givenNumber(-105.84);

        $this->assertEquals(105, $this->target->getIntegerPart());
    }

    public function test_getDecimalPart_should_get_part_of_decimal()
    {
        $this->givenNumber(105.84);

        $this->assertEquals(84, $this->target->getDecimalPart());
    }

    public function test_getDecimalPart_should_get_part_of_decimal_when_negative()
    {
        $this->givenNumber(-105.84);

        $this->assertEquals(84, $this->target->getDecimalPart());
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
