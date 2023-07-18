<?php

namespace QUI\Countries;

use Mockery;
use QUI;
use QUI\Exception;

use function expect;
use function test;

test('that constructor is throwing exceptions on missing arguments', function (array $parameters) {
    new Country($parameters);
})->with([
    'missing countries_iso_code_2' => [[]],
    'missing countries_iso_code_3' => [
        [
            'countries_iso_code_2' => 'US'
        ]
    ],
    'missing countries_id'         => [
        [
            'countries_iso_code_2' => 'US',
            'countries_iso_code_3' => 'USA'
        ]
    ],
    'missing language'             => [
        [
            'countries_iso_code_2' => 'US',
            'countries_iso_code_3' => 'USA',
            'countries_id'         => 1
        ]
    ],
    'missing languages'            => [
        [
            'countries_iso_code_2' => 'US',
            'countries_iso_code_3' => 'USA',
            'countries_id'         => 1,
            'language'             => 'English'
        ]
    ],
    'missing currency'             => [
        [
            'countries_iso_code_2' => 'US',
            'countries_iso_code_3' => 'USA',
            'countries_id'         => 1,
            'language'             => 'English',
            'languages'            => '{"en":"English"}'
        ]
    ]
])->throws(Exception::class);

test('that constructor works without exceptions on correct arguments', function () {
    $parameters = [
        'countries_iso_code_2' => 'US',
        'countries_iso_code_3' => 'USA',
        'countries_id'         => 1,
        'language'             => 'English',
        'languages'            => '{"en":"English"}',
        'currency'             => '$'
    ];

    expect(
        new Country($parameters)
    )->toBeInstanceOf(Country::class);
});

test('getCode returns correct codes with different parameters', function () {
    $isoCode2 = 'US';
    $isoCode3 = 'USA';

    $country = new Country([
        'countries_iso_code_2' => $isoCode2,
        'countries_iso_code_3' => $isoCode3,
        'countries_id'         => 1,
        'language'             => 'English',
        'languages'            => '{"en":"English"}',
        'currency'             => '$'
    ]);

    expect($country->getCode())->toBe($isoCode2)
        ->and($country->getCode('countries_iso_code_2'))->toBe($isoCode2)
        ->and($country->getCode('countries_iso_code_3'))->toBe($isoCode3)
        ->and($country->getCode('foo'))->toBe($isoCode2);
});

test('getCodeToLower returns correct codes with different parameters', function () {
    $country = new Country([
        'countries_iso_code_2' => 'US',
        'countries_iso_code_3' => 'USA',
        'countries_id'         => 1,
        'language'             => 'English',
        'languages'            => '{"en":"English"}',
        'currency'             => '$'
    ]);

    expect($country->getCodeToLower())->toBe('us')
        ->and($country->getCodeToLower('countries_iso_code_2'))->toBe('us')
        ->and($country->getCodeToLower('countries_iso_code_3'))->toBe('usa')
        ->and($country->getCodeToLower('foo'))->toBe('us');
});

test('getCurrencyCode returns correct currency', function () {
    $currency = '$';

    $country = new Country([
        'countries_iso_code_2' => 'US',
        'countries_iso_code_3' => 'USA',
        'countries_id'         => 1,
        'language'             => 'English',
        'languages'            => '{"en":"English"}',
        'currency'             => $currency
    ]);

    expect($country->getCurrencyCode())->toBe($currency);
});

test('getCurrency throws exception if quiqqer/currency not installed', function () {
    Mockery::mock('overload:' . QUI::class)
        ->shouldReceive('getPackage')
        ->once()
        ->with('quiqqer/currency')
        ->andThrow(Exception::class);

    $country = new Country([
        'countries_iso_code_2' => 'US',
        'countries_iso_code_3' => 'USA',
        'countries_id'         => 1,
        'language'             => 'English',
        'languages'            => '{"en":"English"}',
        'currency'             => '$'
    ]);

    $country->getCurrency();
})->throws(Exception::class);

test('getCurrency returns currency object if currency exists', function () {
    $currencyCode = '$';

    Mockery::mock('overload:' . QUI::class)
        ->shouldReceive('getPackage')
        ->once()
        ->with('quiqqer/currency');

    $currencyMock = Mockery::mock('QUI\ERP\Currency\Currency');

    Mockery::mock('overload:' . QUI\ERP\Currency\Handler::class)
        ->shouldReceive('getCurrency')
        ->once()
        ->with($currencyCode)
        ->andReturn($currencyMock);


    (new Country([
        'countries_iso_code_2' => 'US',
        'countries_iso_code_3' => 'USA',
        'countries_id'         => 1,
        'language'             => 'English',
        'languages'            => '{"en":"English"}',
        'currency'             => $currencyCode
    ]))->getCurrency();
});

test('getCurrency returns default currency object if currency does not exist', function () {
    $currencyCode = '$';

    Mockery::mock('alias:' . QUI::class)
        ->shouldReceive('getPackage')
        ->once()
        ->with('quiqqer/currency');

    $currencyMock = Mockery::mock('QUI\ERP\Currency\Currency');

    $currencyHandlerMock = Mockery::mock('alias:QUI\ERP\Currency\Handler');

    $currencyHandlerMock->shouldReceive('getCurrency')
        ->twice()
        ->with($currencyCode)
        ->andReturn($currencyMock);

    $currencyHandlerMock->shouldReceive('getDefaultCurrency')
        ->once()
        ->andReturnUsing(function () {
            echo 'hello';
        });
//        ->andReturn($currencyMock);

    // TODO: shouldReceive once is ignored

    (new Country([
        'countries_iso_code_2' => 'US',
        'countries_iso_code_3' => 'USA',
        'countries_id'         => 1,
        'language'             => 'English',
        'languages'            => '{"en":"English"}',
        'currency'             => $currencyCode
    ]))->getCurrency();
});
