<?php

/**
 * This file contains package_quiqqer_countries_ajax_getCountries
 */

use QUI\Countries\Manager;
use QUI\Cache\Manager as CacheManager;

/**
 * Return the countries
 *
 * @return array
 */
QUI::getAjax()->registerFunction(
    'package_quiqqer_countries_ajax_getCountries',
    function ($lang) {
        if (!isset($lang)) {
            $lang = QUI::getUserBySession()->getLocale()->getCurrent();
        }

        $cacheName = 'quiqqer/countries/list/'.$lang;

        try {
            return CacheManager::get($cacheName);
        } catch (\Exception $Exception) {
        }

        $Locale = new QUI\Locale();
        $Locale->setCurrent($lang);

        $list      = Manager::getSortedList();
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
