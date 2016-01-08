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

        $this->setExpectedException('QUI\Exception');
        QUI\Countries\Manager::get('__');


//        try {
//
//            QUI\Countries\Manager::get('__');
//
//            $this->fail('sollte fehlschlagen');
//
//        } catch (QUI\Exception $Exception) {
//            $this->assertTrue(true);
//        }

    }

    public function testGetCurrencyCode()
    {
        $Country = QUI\Countries\Manager::get('de');
        $Currency = $Country->getCurrencyCode();
        $this->assertEquals($Currency, 'Euro');

    }

//    public function testGetName()
//    {
//        $Country = QUI\Countries\Manager::get('pl');
//        $Code = $Country->getCode();
//        $Name = $Country->getName();
//
//        $localeVar = 'country.' . $Code;
//
////        if (QUI::getLocale()->exists('quiqqer/countries', $localeVar)) {
////            $this->assertEquals($Name, QUI::getLocale()->get('quiqqer/countries', 'irgendwas'));
////        }
//
//        if (1 == 1) {
//            //$this->assertEquals($Name, QUI::getLocale()->get('quiqqer/countries', $localeVar));
//            $this->assertFileExists($Name, QUI::getLocale()->get('quiqqer/countries', $localeVar));
//
//        }
//$test = QUI::getLocale()->exists('quiqqer/countries', $localeVar);
//        var_dump($test);
//        echo "$Name" . "\r\n";
//        echo "$localeVar" . "\r\n";
//        print_r($Country);
////        $this->assertSame($Name, $Country->getAttribute('countries_name'));
//    }
}
