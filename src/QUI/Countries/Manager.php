<?php

/**
 * This file contains the \QUI\Countries\Manager
 */

namespace QUI\Countries;

use QUI;

use function is_string;

/**
 * Country Manager
 *
 * @author  www.pcsg.de (Henning Leutz)
 * @package QUI\Countries
 */
final class Manager extends QUI\QDOM
{
    /**
     * country stack
     *
     * @var array<\QUI\Countries\Country> $countries
     */
    private static array $countries = [];

    private static ?Country $DefaultCountry;

    /**
     * Return the real table name
     */
    public static function getDataBaseTableName(): string
    {
        return QUI::getDBTableName('countries');
    }

    /**
     * Chceks if Mixed is a country
     *
     * @param mixed $Mixed
     */
    public static function isCountry($Mixed): bool
    {
        if (!$Mixed) {
            return false;
        }

        return \get_class($Mixed) == Country::class;
    }

    /**
     * Return the default country
     *
     * @throws QUI\Exception
     */
    public static function getDefaultCountry(): ?Country
    {
        if (!self::$DefaultCountry instanceof Country) {
            try {
                $defaultCountryInConfig = QUI::conf('globals', 'country');

                if (!is_string($defaultCountryInConfig)) {
                    throw new QUI\Exception('Illegal country value in config');
                }

                self::$DefaultCountry = QUI\Countries\Manager::get($defaultCountryInConfig);
            } catch (QUI\Exception $Exception) {
                self::$DefaultCountry = QUI\Countries\Manager::get('de');
            }
        }

        return self::$DefaultCountry;
    }

    /**
     * Get a country
     *
     * @param String $code - the country code
     * @param string $type (optional) - type of code ("countries_iso_code_2" or "countries_iso_code_3")
     *
     * @throws QUI\Exception
     * @example
     * $Country = \QUI\Countries\Manager::get('de');
     * $Country->getName()
     */
    public static function get(string $code, $type = 'countries_iso_code_2'): Country
    {
        if (isset(self::$countries[$code])) {
            return self::$countries[$code];
        }

        $result = QUI::getDataBase()->fetch([
            'from'  => self::getDataBaseTableName(),
            'where' => [
                $type => QUI\Utils\StringHelper::toUpper($code)
            ],
            'limit' => 1
        ]);

        if (!isset($result[0])) {
            throw new QUI\Exception(
                QUI::getLocale()->get('quiqqer/countries', 'exception.country.not.found'),
                404
            );
        }

        self::$countries[$code] = new Country($result[0]);

        return self::$countries[$code];
    }

    /**
     * Returns the complete country list
     *
     * @return array<\QUI\Countries\Country>
     */
    public static function getCompleteList(): array
    {
        try {
            $result = QUI::getDataBase()->fetch([
                'from'  => self::getDataBaseTableName(),
                'order' => 'countries_iso_code_2 ASC'
            ]);
        } catch (QUI\Exception $Exception) {
            QUI\System\Log::writeDebugException($Exception);

            return [];
        }

        return self::parseCountryDbData($result);
    }

    /**
     * Return ths country list
     * Only active counries
     *
     * @return array<\QUI\Countries\Country>
     */
    public static function getList(): array
    {
        try {
            $result = QUI::getDataBase()->fetch([
                'from'  => self::getDataBaseTableName(),
                'where' => [
                    'active' => 1
                ],
                'order' => 'countries_iso_code_2 ASC'
            ]);
        } catch (QUI\Exception $Exception) {
            QUI\System\Log::writeDebugException($Exception);

            return [];
        }

        return self::parseCountryDbData($result);
    }

    /**
     * @param array<mixed> $result
     *
     * @return array<\QUI\Countries\Country>
     */
    protected static function parseCountryDbData($result): array
    {
        $countries = [];

        foreach ($result as $entry) {
            $code = $entry['countries_iso_code_2'];

            if (isset(self::$countries[$code])) {
                $countries[] = self::$countries[$code];
                continue;
            }

            try {
                $Country = new Country($entry);
            } catch (QUI\Exception $Exception) {
                QUI\System\Log::writeException($Exception);
                continue;
            }

            self::$countries[$code] = $Country;

            $countries[] = $Country;
        }

        return $countries;
    }

    /**
     * Return the countries in sorted order
     *
     * @param callable|null|array<mixed> $params - optional, sorting function
     *
     * @return array<\QUI\Countries\Country>
     */
    public static function getSortedList($params = null): array
    {
        $complete = false;
        $sort     = null;

        if (!\is_array($params)) {
            $sort = $params;
        } else {
            if (isset($params['sort'])) {
                $sort = $params['sort'];
            }

            if (isset($params['complete'])) {
                $complete = $params['complete'];
            }
        }

        $countries = $complete ? self::getCompleteList() : self::getList();

        if ($sort === null) {
            $sort = static fn(Country $CountryA, Country $CountryB): int => \strnatcmp(
                $CountryA->getName(),
                $CountryB->getName()
            );
        }

        \usort($countries, $sort);

        return $countries;
    }

    /**
     * Return all available country codes
     *
     * @return array<string>
     */
    public static function getAllCountryCodes(): array
    {
        $result    = [];
        $countries = self::getList();

        foreach ($countries as $Country) {
            $result[] = $Country->getCode();
        }

        return $result;
    }

    /**
     * Exist the country code in the database?
     *
     * @param string $code - Country code
     */
    public static function existsCountryCode(string $code): bool
    {
        try {
            self::get($code);

            return true;
        } catch (QUI\Exception $Exception) {
        }

        return false;
    }
}
