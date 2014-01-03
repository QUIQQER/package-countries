<?php

/**
 * This file contains the \QUI\Countries\Country
 */

namespace QUI\Countries;

/**
 * A Country
 *
 * @author www.pcsg.de (Henning Leutz)
 * @package com.pcsg.qui.utils.countries
 */
class Country extends \QUI\QDOM
{
    /**
     * construcor
     * If you want a country, use the manager
     *
     * @example
     * $Country = \QUI\Countries\Manager::get('de');
     * $Country->getName()
     *
     * @param Array $params
     */
    public function __construct($params)
    {
        if ( !isset( $params['countries_iso_code_2'] ) ) {
            throw new \QUI\Exception( 'Parameter countries_iso_code_2 fehlt' );
        }

        if ( !isset( $params['countries_iso_code_3'] ) ) {
            throw new \QUI\Exception( 'Parameter countries_iso_code_3 fehlt' );
        }

        if ( !isset( $params['countries_name'] ) ) {
            throw new \QUI\Exception( 'Parameter countries_name fehlt' );
        }

        if ( !isset( $params['countries_id'] ) ) {
            throw new \QUI\Exception( 'Parameter countries_id fehlt' );
        }

        parent::setAttributes( $params );
    }

    /**
     * Return the country code
     * iso_code_2 or iso_code_2
     *
     * @param String $type - countries_iso_code_2 or countries_iso_code_3
     * @return String
     */
    public function getCode($type='countries_iso_code_2')
    {
        switch ( $type )
        {
            default:
            case 'countries_iso_code_2':
                return $this->getAttribute( 'countries_iso_code_2' );
            break;

            case 'countries_iso_code_3':
                return $this->getAttribute( 'countries_iso_code_3' );
            break;
        }
    }

    /**
     * Return the name of the country
     * observed System_Locale
     *
     * @return String
     */
    public function getName()
    {
        if ( $this->existsAttribute( \QUI::getLocale()->getCurrent() ) ) {
            return $this->getAttribute( \QUI::getLocale()->getCurrent() );
        }

        return $this->getAttribute( 'countries_name' );
    }
}
