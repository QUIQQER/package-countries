/**
 * Countries handler
 *
 * @module package/quiqqer/countries/bin/classes/Countries
 * @author www.pcsg.de (Patrick Müller)
 * @author www.pcsg.de (Henning Leutz)
 *
 * @require qui/classes/DOM
 * @require Ajax
 */
define('package/quiqqer/countries/bin/classes/Countries', [

    'qui/classes/DOM',
    'Ajax'

], function (QUIDOM, QUIAjax) {
    "use strict";

    var pkg = 'quiqqer/countries';

    return new Class({

        Extends: QUIDOM,
        Type   : 'package/quiqqer/countries/bin/classes/Countries',

        initialize: function () {
            this.$countries = null;
            this.$codes     = {};
        },

        /**
         * Return the country list
         *
         * @return {Promise}
         */
        getCountries: function () {
            if (this.$countries) {
                return Promise.resolve(this.$countries);
            }

            var self = this;

            return new Promise(function (resolve, reject) {
                QUIAjax.get('package_quiqqer_countries_ajax_getCountries', function (result) {
                    self.$countries = result;
                    resolve(result);
                }, {
                    'package': 'quiqqer/countries',
                    onError  : reject
                });
            });
        },

        /**
         * Get country data by country code
         *
         * @param {string} countryCode - Country code (ISO 3166-1 alpha-2 or ISO 3166-1 alpha-3)
         * @returns {Promise}
         */
        getCountryByCode: function (countryCode) {
            if (countryCode in this.$codes) {
                return Promise.resolve(this.$codes[countryCode]);
            }

            var self = this;

            return new Promise(function (resolve, reject) {
                QUIAjax.get('package_quiqqer_countries_ajax_getCountryByCode', function (result) {
                    self.$codes[countryCode] = result;
                    resolve(result);
                }, {
                    'package'  : pkg,
                    onError    : reject,
                    countryCode: countryCode
                });
            });
        }
    });
});
