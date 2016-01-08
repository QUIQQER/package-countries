<?php

namespace QUITests\QUI\Countries;

use QUI;

/**
 * Class FieldsTest
 */
class CountryTest extends \PHPUnit_Framework_TestCase
{
    public function testCountry()
    {
        $Country = QUI\Countries\Manager::get('de');
        $this->assertNotEmpty($Country);
        $this->assertNotEmpty($Country->getCode());
        $this->assertNotEmpty($Country->getName());
    }

    public function testGetCode()
    {
        $Country = QUI\Countries\Manager::get('gb');

        if ($Country->getCode('countries_iso_code_2')){
            $this->assertEquals($Country->getCode('countries_iso_code_2'), 'GB');
        }

        if ($Country->getCode('countries_iso_code_3')){
            $this->assertEquals($Country->getCode('countries_iso_code_3'), 'GBR');
        }

//        $this->setExpectedException('QUI\Exception');
//        QUI\Countries\Manager::get('de');


        try {

            QUI\Countries\Manager::get('de');

            $this->fail('sollte fehlschlagen');

        } catch (QUI\Exception $Exception) {
            $this->assertTrue(true);
        }

    }
//
//    public function testGetCurrencyCode()
//    {
//        $Country = QUI\Countries\Manager::get('de');
//        $Currency = $Country->getCurrencyCode();
//        $this->assertEquals($Currency, 'Euro');
//
//    }

    public function testGetName()
    {
        $Country = QUI\Countries\Manager::get('pl');
        $code = $Country->getCode();
        $name = $Country->getName();

        $localeVar = 'country.' . $code;

        if (QUI::getLocale()->exists('quiqqer/countries', $localeVar)) {
            $this->assertEquals($name, QUI::getLocale()->get('quiqqer/countries', 'irgendwas'));
        }

        // Hen! Hier kommt false trotzd update. Gibt die locale nicht?
        //var_dump(QUI::getLocale()->exists('quiqqer/countries', $localeVar));
    }
}
