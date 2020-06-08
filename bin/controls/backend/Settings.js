/**
 * @module package/quiqqer/countries/bin/controls/backend/Settings
 * @author www.pcsg.de (Henning Leutz)
 */
define('package/quiqqer/countries/bin/controls/backend/Settings', [

    'qui/QUI',
    'qui/controls/Control',
    'controls/grid/Grid',
    'Locale',
    'Ajax'

], function (QUI, QUIControl, Grid, QUILocale, QUIAjax) {
    "use strict";

    return new Class({

        Extends: QUIControl,
        Type   : 'package/quiqqer/countries/bin/controls/backend/Settings',

        Binds: [
            '$onInject',
            '$onImport'
        ],

        initialize: function (options) {
            this.parent(options);

            this.$Grid = null;

            this.addEvents({
                onInject: this.$onInject,
                onImport: this.$onImport
            });
        },

        /**
         * event: on inject
         */
        $onInject: function () {
        },

        /**
         * event: on import
         */
        $onImport: function () {
            var self      = this;
            var Container = new Element('div').wraps(this.getElm());
            var Cell      = Container.getParent('td');

            Container.setStyle('width', 500);

            this.$Grid = new Grid(Container, {
                columnModel: [{
                    header   : '',
                    dataIndex: 'checkbox',
                    dataType : 'node',
                    width    : 60
                }, {
                    header   : QUILocale.get('quiqqer/quiqqer', 'language.code'),
                    dataIndex: 'code',
                    dataType : 'string',
                    width    : 100
                }, {
                    header   : QUILocale.get('quiqqer/quiqqer', 'country'),
                    dataIndex: 'country',
                    dataType : 'string',
                    width    : 150
                }],

                height: 400
            });


            Promise.all([
                this.getCompleteCountries(),
                this.getCountries()
            ]).then(function (result) {
                var complete = result[0];
                var active   = result[1];
                var data     = [];

                for (var code in complete) {
                    if (!complete.hasOwnProperty(code)) {
                        continue;
                    }

                    data.push({
                        code    : code,
                        country : complete[code],
                        checkbox: new Element('input', {
                            type   : 'checkbox',
                            value  : code,
                            checked: typeof active[code] !== 'undefined'
                        })
                    });
                }

                self.$Grid.setData({
                    data: data
                });

                self.$Grid.setWidth(Cell.getSize().x - 20);

                self.$Grid.getElm().getElements('li').addEvent('click', function (event) {
                    var Target = event.target;

                    if (Target.nodeName === 'INPUT') {
                        self.$Grid.disable();
                        self.saveCountry(
                            Target.value,
                            Target.checked ? 1 : 0
                        ).then(function () {
                            self.$Grid.enable();
                        }).catch(function () {
                            Checkbox.checked = !Checkbox.checked;
                            self.$Grid.enable();
                        });
                        return;
                    }

                    event.stop();

                    if (Target.nodeName !== 'LI') {
                        Target = Target.getParent('li');
                    }

                    var Checkbox     = Target.getElement('input[type="checkbox"]');
                    Checkbox.checked = !Checkbox.checked;

                    self.$Grid.disable();
                    self.saveCountry(
                        Checkbox.value,
                        Checkbox.checked ? 1 : 0
                    ).then(function () {
                        self.$Grid.enable();
                    }).catch(function () {
                        Checkbox.checked = !Checkbox.checked;
                        self.$Grid.enable();
                    });
                });
            });
        },

        /**
         * return all countries
         *
         * @return {Promise}
         */
        getCompleteCountries: function () {
            return new Promise(function (resolve) {
                QUIAjax.get('package_quiqqer_countries_ajax_getCompleteCountries', resolve, {
                    'package': 'quiqqer/countries'
                });
            });
        },

        /**
         * return only the active countries
         *
         * @return {Promise}
         */
        getCountries: function () {
            return new Promise(function (resolve) {
                QUIAjax.get('package_quiqqer_countries_ajax_getCountries', resolve, {
                    'package': 'quiqqer/countries'
                });
            });
        },

        /**
         * Change the country status
         *
         * @param code
         * @param status
         * @return {Promise}
         */
        saveCountry: function (code, status) {
            return new Promise(function (resolve, reject) {
                QUIAjax.post('package_quiqqer_countries_ajax_changeCountryStatus', resolve, {
                    'package': 'quiqqer/countries',
                    code     : code,
                    status   : status,
                    onError  : reject
                });
            });
        }
    });
});
