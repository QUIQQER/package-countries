<?php

namespace QUI\Countries\Controls;

use PHPUnit\Framework\TestCase;

class SelectTest extends TestCase
{
    public function testConstructorSetsDefaultAttributes(): void
    {
        $selectControl = new Select();

        $this->assertEquals('countries', $selectControl->getAttribute('name'), '"name" attribute');
        $this->assertEquals('', $selectControl->getAttribute('selected'), '"selected" attribute');
        $this->assertFalse($selectControl->getAttribute('class'), '"class" attribute');
        $this->assertFalse($selectControl->getAttribute('required'), '"required" attribute');
        $this->assertTrue($selectControl->getAttribute('use-geo-location'), '"use-geo-location" attribute');
    }

    public function testCreate(): void
    {
        $this->markTestIncomplete(
            'Figure out how to test with the side-effects of this method'
        );
    }
}
