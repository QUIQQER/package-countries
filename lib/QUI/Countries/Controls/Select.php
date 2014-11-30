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
 * @author www.pcsg.de (Henning Leutz)
 * @package quiqqer/countries
 */
class Select extends QUI\Control
{
    /**
     * constructor
     * @param array $attributes
     */
    public function __construct($attributes=array())
    {
        // default
        $this->setAttributes(array(
            'name'     => 'countries',
            'selected' => ''
        ));

        $this->setAttributes( $attributes );
    }

    /**
     * (non-PHPdoc)
     * @see \QUI\Control::create()
     *
     * @return String
     */
    public function create()
    {
        $countries = Manager::getList();
        $result    = '<select name="">';

        $selected = $this->getAttribute('selected');

        /* @var $Country \QUI\Countries\Country */
        foreach ( $countries as $Country )
        {
            $result .= '<option value="'. $Country->getCode() .'"';

            if ( $Country->getCode() == $selected ) {
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