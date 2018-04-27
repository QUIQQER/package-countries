<?php

/**
 * This file contains \QUI\Countries\Controls\Select
 */

namespace QUI\Countries\Controls;

use QUI;
use QUI\Countries\Manager;

/**
 * Country Select field
 *
 * @author  www.pcsg.de (Henning Leutz)
 * @package quiqqer/countries
 */
class Select extends QUI\Control
{
    /**
     * constructor
     *
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        // default
        $this->setAttributes([
            'name'             => 'countries',
            'selected'         => '',
            'class'            => false,    // css class to add to the select html element
            'required'         => false,
            'use-geo-location' => true
        ]);

        parent::__construct($attributes);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \QUI\Control::create()
     *
     * @return String
     */
    public function create()
    {
        $countries = Manager::getSortedList();
        $result    = '<select data-qui="package/quiqqer/countries/bin/controls/Select" ';

        if ($this->getAttribute('name')) {
            $result .= ' name="'.$this->getAttribute('name').'"';
        }

        if ($this->getAttribute('class')) {
            $result .= ' class="'.$this->getAttribute('class').'"';
        }

        if ($this->getAttribute('required')) {
            $result .= ' required';
        }

        if (!$this->getAttribute('no-autocomplete')) {
            $result .= ' autocomplete="country-name"';
        } else {
            $result .= ' autocomplete="off"';
        }

        $result .= '>';

        $selected = $this->getAttribute('selected');

        if (empty($selected) && $this->getAttribute('use-geo-location')) {
            $Country = null;

            if (isset($_SERVER["GEOIP_COUNTRY_CODE"])) { // only for apache
                try {
                    $Country = QUI\Countries\Manager::get($_SERVER["GEOIP_COUNTRY_CODE"]);
                } catch (QUI\Exception $Exception) {
                }
            }

            if ($Country) {
                $selected = $Country->getCode();
            }
        }

        /* @var $Country \QUI\Countries\Country */
        foreach ($countries as $Country) {
            $result .= '<option value="'.$Country->getCode().'"';

            if ($Country->getCodeToLower() == mb_strtolower($selected)) {
                $result .= ' selected="selected"';
            }

            $result .= '>';
            $result .= $Country->getName();
            $result .= '</option>';
        }

        $result .= '</select>';

        return $result;
    }
}
