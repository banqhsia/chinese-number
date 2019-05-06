<?php

namespace Tests\Unit;

trait AssertionHelper
{
    private function givenNumber($number)
    {
        $this->actual = (string) $this->target->number($number);
    }

    private function resultShouldBe($expected)
    {
        $this->assertEquals($expected, $this->actual);
    }
}
