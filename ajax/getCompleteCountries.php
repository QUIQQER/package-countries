<?php

/**
 * This file contains package_quiqqer_countries_ajax_getCompleteCountries
 */

use QUI\Cache\Manager as CacheManager;
use QUI\Countries\Manager;

/**
 * Return the countries
 *
 * @return array
 */
QUI::$Ajax->registerFunction(
    'package_quiqqer_countries_ajax_getCompleteCountries',
    function ($lang) {
        if (!isset($lang)) {
            $lang = QUI::getUserBySession()->getLocale()->getCurrent();
        }

        $cacheName = 'quiqqer/countries/complete-list/' . $lang;

        try {
            return CacheManager::get($cacheName);
        } catch (\Exception $Exception) {
        }

        $Locale = new QUI\Locale();
        $Locale->setCurrent($lang);

        $list = Manager::getSortedList([
            'complete' => true
        ]);

        $countries = [];

        /** @var \QUI\Countries\Country $Country */
        foreach ($list as $Country) {
            $countries[$Country->getCode()] = $Country->getName($Locale);
        }

        CacheManager::set($cacheName, $countries);

        return $countries;
    },
    ['lang'],
    false
);
