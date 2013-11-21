<?php

/**
 * This file contains the \QUI\Countries\Manager
 */

namespace QUI\Countries;

/**
 * Country Manager
 *
 * @author www.pcsg.de (Henning Leutz)
 * @package com.pcsg.qui.utils.countries
 */

class Manager extends \QUI\QDOM
{
    /**
     * Return the real table name
     *
     * @return String
     */
    static function Table()
    {
        return QUI_DB_PRFX .'countries';
    }

    /**
     * Get a country
     *
     * @param String $code - the country code
     * @return Utils_Countries_Country
     *
     * @example
     * $Country = Utils_Countries_Manager::get('de');
     * $Country->getName()
     */
    static function get($code)
    {
        $result = \QUI::getDB()->select(array(
            'from'  => self::Table(),
            'where' => array(
                'countries_iso_code_2' => \QUI\Utils\String::toUpper(
                    $code
                )
              ),
              'limit' => '1'

        ));

        if ( !isset( $result[0] ) ) {
            throw new \QUI\Exception( 'Das Land wurde nicht gefunden', 404 );
        }

        return new \QUI\Countries\Country( $result[0] );
    }

    /**
     * Get the complete country list
     *
     * @return Array
     */
    static function getList()
    {
        $order = 'countries_name ASC';

        if ( \QUI::getLocale()->getCurrent() === 'en' ) {
            $order = 'en ASC';
        }

        $result = \QUI::getDB()->select(array(
            'from'  => self::Table(),
            'order' => $order
        ));

        $countries = array();

        foreach ( $result as $entry ) {
            $countries[] = new \QUI\Countries\Country( $entry );
        }

        return $countries;
    }
}
