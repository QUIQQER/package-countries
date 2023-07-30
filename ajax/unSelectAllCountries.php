<?php

/**
 * This file contains package_quiqqer_countries_ajax_unSelectAllCountries
 */

use QUI\Countries\Manager;

/**
 * Unselect all countries
 *
 * @return array
 */
QUI::$Ajax->registerFunction(
    'package_quiqqer_countries_ajax_unSelectAllCountries',
    function (): void {
        QUI::getDataBase()->update(
            Manager::getDataBaseTableName(),
            ['active' => 0],
            ''
        );

        QUI\Cache\Manager::clear('quiqqer/countries');
    },
    false,
    'Permission::checkSU'
);
