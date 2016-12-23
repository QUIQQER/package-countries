/**
 * Countries handler
 *
 * @module package/quiqqer/countries/bin/classes/Countries
 * @author www.pcsg.de (Patrick Müller)
 *
 * @require qui/QUI
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

        /**
         * Get country data by country code
         *
         * @param {string} countryCode - Country code (ISO 3166-1 alpha-2 or ISO 3166-1 alpha-3)
         * @returns {Promise}
         */
        getCountryByCode: function (countryCode) {
            return new Promise(function (resolve, reject) {
                QUIAjax.get('package_quiqqer_countries_ajax_getCountryByCode', resolve, {
                    'package'  : pkg,
                    onError    : reject,
                    countryCode: countryCode
                });
            });
        }
    });
});
