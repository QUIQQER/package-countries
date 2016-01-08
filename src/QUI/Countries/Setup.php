<?php

/**
 * This file contains the \QUI\Countries\Setup
 */

namespace QUI\Countries;

use QUI;

/**
 * Country setup
 *
 * @author  www.pcsg.de (Henning Leutz)
 * @package quiqqer/countries
 */
class Setup extends QUI\QDOM
{
    /**
     * Country setup
     * Import the database
     */
    public static function setup()
    {
        // Countries
        $path = str_replace('lib/QUI/Countries/Setup.php', '', __FILE__);

        $db_countries = $path . 'db/countries.sql';
        $PDO          = QUI::getDataBase()->getPDO();

        if (!file_exists($db_countries)) {
            return;
        }

        $sql = file_get_contents($db_countries);
        $sql = str_replace('{$TABLE}', Manager::getDataBaseTableName(), $sql);
        $sql = explode(';', $sql);

        foreach ($sql as $query) {
            $query = trim($query);

            if (empty($query)) {
                continue;
            }

            $PDO->exec($query);
        }
    }
}
