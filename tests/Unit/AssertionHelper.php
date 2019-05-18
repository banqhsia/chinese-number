<?php

namespace Tests\Unit;

trait AssertionHelper
{
    private function givenNumber($number)
    {
        $this->target = $this->target->number($number);
    }

    private function resultShouldBe($expected)
    {
        $this->assertEquals($expected, (string) $this->target->render());
    }
}
