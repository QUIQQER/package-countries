<?php

use QUI\Countries\Manager;
use QUI\Cache\Manager as CacheManager;

/**
 * Get list of countries (in specific language)
 *
 * @param string $lang - The language the country names shoud be in
 * @return array
 */
function package_quiqqer_countries_ajax_getCountries($lang)
{
    $cacheName = 'quiqqer/countries/list/' . $lang;

    try {
        return CacheManager::get($cacheName);
    } catch (\Exception $Exception) {
        // build new country list
    }

    $Locale = new \QUI\Locale();
    $Locale->setCurrent($lang);

    $list      = Manager::getSortedList();
    $countries = array();

    /** @var \QUI\Countries\Country $Country */
    foreach ($list as $Country) {
        $countries[$Country->getCode()] = $Country->getName($Locale);
    }

    CacheManager::set($cacheName, $countries);

    return $countries;
}

\QUI::$Ajax->register(
    'package_quiqqer_countries_ajax_getCountries',
    array('lang'),
    'Permission::checkAdminUser'
);
