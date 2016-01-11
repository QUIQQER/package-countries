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

        try {

            QUI\Countries\Manager::get('__');

            $this->fail('Das sollte fehlschlagen');

        } catch (QUI\Exception $Exception) {
            $this->assertTrue(true);
        }

    }

    public function test__construct()
    {
        $Country = QUI\Countries\Manager::get('nl');
        if (!isset($params['countries_iso_code_2'])) {
            $this->assertFalse( true);
        }
    }

    public function testGetCode()
    {
        $Country = QUI\Countries\Manager::get('gb');

        if ($Country->getAttribute('countries_iso_code_2')) {
            $this->assertEquals($Country->getCode('countries_iso_code_2'), 'GB');
        }

        if ($Country->getAttribute('countries_iso_code_3')) {
            $this->assertEquals($Country->getCode('countries_iso_code_3'), 'GBR');
        }

//        $this->setExpectedException('QUI\Exception');
//        QUI\Countries\Manager::get('__');
    }



    public function testGetCurrencyCode()
    {
        $Country = QUI\Countries\Manager::get('de');
        $currency = $Country->getCurrencyCode();

//        var_dump($Country);
//        var_dump($currency);
        $this->assertEquals($currency, 'Euro');
    }

    public function testGetName()
    {
        $Country = QUI\Countries\Manager::get('pl');
        $code = $Country->getAttribute('countries_iso_code_2');
        $name = $Country->getName();

        $localeVar = 'country.' . $code;

        if (QUI::getLocale()->exists('quiqqer/countries', $localeVar)) {
            $this->assertEquals($name, QUI::getLocale()->get('quiqqer/countries', $localeVar));
        }

        // Hen! Hier kommt false (locale update gemacht).
        //var_dump(QUI::getLocale()->exists('quiqqer/countries', $localeVar));

        $this->assertEquals($name, 'Polen');
    }
}
