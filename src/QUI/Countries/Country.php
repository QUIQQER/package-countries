<?php

/**
 * This file contains the \QUI\Countries\Country
 */

namespace QUI\Countries;

use QUI;

/**
 * A Country
 *
 * @author  www.pcsg.de (Henning Leutz)
 * @package QUI\Countries
 */
class Country extends QUI\QDOM
{
    /**
     * construcor
     * If you want a country, use the manager
     *
     * @example
     * $Country = \QUI\Countries\Manager::get('de');
     * $Country->getName()
     *
     * @param array $params
     *
     * @throws QUI\Exception
     */
    public function __construct($params)
    {
        if (!isset($params['countries_iso_code_2'])) {
            throw new QUI\Exception('Parameter countries_iso_code_2 fehlt');
        }

        if (!isset($params['countries_iso_code_3'])) {
            throw new QUI\Exception('Parameter countries_iso_code_3 fehlt');
        }

        if (!isset($params['countries_id'])) {
            throw new QUI\Exception('Parameter countries_id fehlt');
        }

        if (!isset($params['language'])) {
            throw new QUI\Exception('Parameter language fehlt');
        }

        if (!isset($params['languages'])) {
            throw new QUI\Exception('Parameter languages fehlt');
        }

        if (!isset($params['currency'])) {
            throw new QUI\Exception('Parameter currency fehlt');
        }

        parent::setAttributes($params);
    }

    /**
     * Return the country code
     * iso_code_2 or iso_code_2
     *
     * @param string $type - countries_iso_code_2 or countries_iso_code_3
     *
     * @return string
     */
    public function getCode($type = 'countries_iso_code_2')
    {
        switch ($type) {
            default:
            case 'countries_iso_code_2':
                return $this->getAttribute('countries_iso_code_2');
                break;

            case 'countries_iso_code_3':
                return $this->getAttribute('countries_iso_code_3');
                break;
        }
    }

    /**
     * Return the currency object
     *
     * @return QUI\ERP\Currency\Currency
     * @todo not implemented
     */
    public function getCurrencyCode()
    {
        return $this->getAttribute('currency');
    }

    /**
     * Return the currency of the country
     *
     * @return QUI\ERP\Currency\Currency
     */
    public function getCurrency()
    {
        // currency installed?
        QUI::getPackage('quiqqer/currency');
        
        try {
            return QUI\ERP\Currency\Handler::getCurrency(
                $this->getCurrencyCode()
            );
        } catch (QUI\Exception $Exception) {
        }

        return QUI\ERP\Currency\Handler::getDefaultCurrency();
    }

    /**
     * Return the name of the country
     * observed System_Locale
     *
     * @return string
     */
    public function getName()
    {
        $localeVar = 'country.' . $this->getCode();

        if (QUI::getLocale()->exists('quiqqer/countries', $localeVar)) {
            return QUI::getLocale()->get('quiqqer/countries', $localeVar);
        }

        return $this->getAttribute('countries_name');
    }


    public function getLang()
    {

    }


    public function getLanguages()
    {

    }
}
