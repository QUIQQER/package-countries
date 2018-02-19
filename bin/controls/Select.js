/**
 * Select for countries
 *
 * @module package/quiqqer/countries/bin/controls/Select
 * @author www.pcsg.de (Patrick Müller)
 *
 * @require qui/controls/buttons/Select
 * @require qui/controls/loader/Loader
 * @require Ajax
 * @require Locale
 */
define('package/quiqqer/countries/bin/controls/Select', [

    'qui/controls/buttons/Select',
    'qui/controls/loader/Loader',

    'Ajax',
    'Locale'

], function (QUISelect, QUILoader, QUIAjax, QUILocale) {
    "use strict";

    return new Class({

        Extends: QUISelect,
        Type   : 'package/quiqqer/countries/bin/controls/Select',

        Binds: [
            '$onInject',
            '$onCreate',
            '$onImport',
            '$load'
        ],

        options: {
            showIcons   : false,
            searchable  : true,
            initialValue: false    // sets an initial value for the dropdown menu (if it exists!)
        },

        initialize: function (options) {
            this.parent(options);

            this.addEvents({
                onCreate: this.$onCreate,
                onInject: this.$onInject,
                onImport: this.$onImport,
                onChange: this.$onChange
            });

            this.Loader       = new QUILoader();
            this.$currentCode = QUILocale.getCurrent();
        },

        /**
         * event on DOMElement creation
         */
        $onCreate: function () {
            this.$Elm.addClass('quiqqer-countries-select');
            this.$Elm.set('data-qui', 'package/quiqqer/countries/bin/controls/Select');

            this.Loader.inject(this.$Content);
        },

        /**
         * event: on control import
         */
        $onImport: function () {
            this.$Input = this.getElm();
            var Elm     = this.create();

            if (this.$Input.nodeName === 'INPUT') {
                this.$Input.type = 'hidden';

                if (this.$Input.value !== '') {
                    this.$currentCode = this.$Input.value;
                }

                Elm.inject(this.$Input, 'after');

                this.$load();
                return;
            }

            if (this.$Input.nodeName === 'SELECT') {
                var optionElms = this.$Input.getElements('option');

                Elm.inject(this.$Input, 'after');

                for (var i = 0, len = optionElms.length; i < len; i++) {
                    var OptionElm = optionElms[i];

                    this.appendChild(
                        OptionElm.innerText,
                        OptionElm.value,
                        false
                    );
                }

                this.$Input.setStyle('display', 'none');
                this.setValue(this.$Input.value);
            }
        },

        /**
         * event: on control inject
         */
        $onInject: function () {
            this.$load();
        },

        /**
         * event: onChange Select
         *
         * @param {string} value - selected value
         */
        $onChange: function (value) {
            this.$Input.value = value;
        },

        /**
         * Load data
         */
        $load: function () {
            var self = this;

            this.Loader.show();

            this.$getCountryList().then(function (Countries) {
                for (var countryCode in Countries) {
                    if (!Countries.hasOwnProperty(countryCode)) {
                        continue;
                    }

                    self.appendChild(
                        Countries[countryCode],
                        countryCode,
                        false // vorerst ohne Flaggen
                        //URL_BIN_DIR + '16x16/flags/' + countryCode.toLowerCase() + '.png'
                    );
                }

                if (self.$currentCode.toUpperCase() in Countries) {
                    self.setValue(self.$currentCode.toUpperCase());
                }

                self.Loader.hide();
            });
        },

        /**
         * Get country list
         *
         * @return {Promise}
         */
        $getCountryList: function () {
            return new Promise(function (resolve, reject) {
                QUIAjax.get('package_quiqqer_countries_ajax_getCountries', resolve, {
                    'package': 'quiqqer/countries',
                    onError  : reject,
                    lang     : QUILocale.getCurrent()
                });
            });
        }
    });

});