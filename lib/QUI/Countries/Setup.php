<?php

/**
 * This file contains the \QUI\Countries\Setup
 */

namespace QUI\Countries;

/**
 * Country Manager
 *
 * @author www.pcsg.de (Henning Leutz)
 * @package com.pcsg.qui.utils.countries
 */

class Setup extends \QUI\QDOM
{
    /**
     * Country setup
     */
    static function setup()
    {
        // Countries
        $path = str_replace( 'lib/QUI/Countries/Setup.php', '', __FILE__ );

        $db_countries = $path .'db/countries.sql';
        $PDO          = \QUI::getDataBase()->getPDO();

        if ( !file_exists( $db_countries ) ) {
            return;
        }

        $sql = file_get_contents( $db_countries );
        $sql = str_replace( '{$TABLE}', \QUI\Countries\Manager::Table(), $sql );
        $sql = explode( ';', $sql );

        foreach ( $sql as $query )
        {
            $query = trim( $query );

            if ( empty( $query ) ) {
                continue;
            }

            $PDO->exec( $query );
        }
    }
}
