<?php

/**
 * This file contains the \QUI\Countries\Manager
 */

namespace QUI\Countries;

use QUI;

/**
 * Country Manager
 *
 * @author  www.pcsg.de (Henning Leutz)
 * @package QUI\Countries
 */
class Manager extends QUI\QDOM
{
    /**
     * country stack
     *
     * @var array
     */
    private static $countries = array();

    /**
     * Return the real table name
     *
     * @return string
     */
    public static function getDataBaseTableName()
    {
        return QUI::getDBTableName('countries');
    }

    /**
     * Chceks if Mixed is a country
     *
     * @param mixed $Mixed
     * @return boolean
     */
    public static function isCountry($Mixed)
    {
        if (!$Mixed) {
            return false;
        }

        return get_class($Mixed) == Country::class;
    }

    /**
     * Get a country
     *
     * @param String $code - the country code
     *
     * @return QUI\Countries\Country
     * @throws QUI\Exception
     *
     * @example
     * $Country = \QUI\Countries\Manager::get('de');
     * $Country->getName()
     */
    public static function get($code)
    {
        if (isset(self::$countries[$code])) {
            return self::$countries[$code];
        }

        $result = QUI::getDataBase()->fetch(array(
            'from'  => self::getDataBaseTableName(),
            'where' => array(
                'countries_iso_code_2' => QUI\Utils\StringHelper::toUpper($code)
            ),
            'limit' => '1'
        ));

        if (!isset($result[0])) {
            throw new QUI\Exception('Das Land wurde nicht gefunden', 404);
        }

        self::$countries[$code] = new Country($result[0]);

        return self::$countries[$code];
    }

    /**
     * Get the complete country list
     *
     * @return array
     */
    public static function getList()
    {
        $result = QUI::getDataBase()->fetch(array(
            'from'  => self::getDataBaseTableName(),
            'order' => 'countries_iso_code_2 ASC'
        ));

        $countries = array();

        foreach ($result as $entry) {
            $code = $entry['countries_iso_code_2'];

            if (isset(self::$countries[$code])) {
                $countries[] = self::$countries[$code];
                continue;
            }

            $Country = new Country($entry);

            self::$countries[$code] = $Country;

            $countries[] = $Country;
        }

        return $countries;
    }

    /**
     * Return all available country codes
     *
     * @return array
     */
    public static function getAllCountryCodes()
    {
        $result    = array();
        $countries = self::getList();

        foreach ($countries as $Country) {
            /* @var $Country Country */
            $result[] = $Country->getCode();
        }

        return $result;
    }

    /**
     * Exist the country code in the database?
     *
     * @param string $code - Country code
     *
     * @return bool
     */
    public static function existsCountryCode($code)
    {
        try {
            self::get($code);

            return true;
        } catch (QUI\Exception $Exception) {
        }

        return false;
    }
}
