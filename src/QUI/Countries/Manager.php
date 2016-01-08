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
 * @package quiqqer/countries
 */
class Manager extends QUI\QDOM
{
    /**
     * Return the real table name
     *
     * @return string
     */
    public static function TABLE()
    {
        return QUI_DB_PRFX . 'countries';
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
        $result = QUI::getDataBase()->fetch(array(
            'from' => self::TABLE(),
            'where' => array(
                'countries_iso_code_2' => QUI\Utils\StringHelper::toUpper($code)
            ),
            'limit' => '1'
        ));

        if (!isset($result[0])) {
            throw new QUI\Exception('Das Land wurde nicht gefunden', 404);
        }

        return new Country($result[0]);
    }

    /**
     * Get the complete country list
     *
     * @return array
     */
    public static function getList()
    {
        $order = 'countries_name ASC';

        if (QUI::getLocale()->getCurrent() === 'en') {
            $order = 'en ASC';
        }

        $result = QUI::getDataBase()->fetch(array(
            'from' => self::TABLE(),
            'order' => $order
        ));

        $countries = array();

        foreach ($result as $entry) {
            $countries[] = new Country($entry);
        }

        return $countries;
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
