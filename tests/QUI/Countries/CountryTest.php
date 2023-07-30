<?php

namespace QUI\Countries;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\TestCase;

use QUI;
use QUI\Exception;

use function json_encode;

final class CountryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public static function constructorThrowsExceptionOnMissingArgumentsProvider(): array
    {
        return [
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
        ];
    }

    #[DataProvider('constructorThrowsExceptionOnMissingArgumentsProvider')]
    public function testConstructorThrowsExceptionOnMissingArguments($parameters): void
    {
        $this->expectException(Exception::class);

        new Country($parameters);
    }

    public function testConstructorWorksWithoutExceptionsOnCorrectArguments(): void
    {
        $parameters = [
            'countries_iso_code_2' => 'US',
            'countries_iso_code_3' => 'USA',
            'countries_id'         => 1,
            'language'             => 'English',
            'languages'            => '{"en":"English"}',
            'currency'             => '$'
        ];

        $country = new Country($parameters);

        $this->assertInstanceOf(Country::class, $country);
    }

    public function testGetCodeReturnsCorrectCodesWithDifferentParameters(): void
    {
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

        $this->assertSame($isoCode2, $country->getCode());
        $this->assertSame($isoCode2, $country->getCode('countries_iso_code_2'));
        $this->assertSame($isoCode3, $country->getCode('countries_iso_code_3'));
        $this->assertSame($isoCode2, $country->getCode('foo'));
    }

    public function testGetCodeToLowerReturnsCorrectCodesWithDifferentParameters(): void
    {
        $country = new Country([
            'countries_iso_code_2' => 'US',
            'countries_iso_code_3' => 'USA',
            'countries_id'         => 1,
            'language'             => 'English',
            'languages'            => '{"en":"English"}',
            'currency'             => '$'
        ]);

        $this->assertSame('us', $country->getCodeToLower());
        $this->assertSame('us', $country->getCodeToLower('countries_iso_code_2'));
        $this->assertSame('usa', $country->getCodeToLower('countries_iso_code_3'));
        $this->assertSame('us', $country->getCodeToLower('foo'));
    }

    public function testGetCurrencyCodeReturnsCorrectCurrency(): void
    {
        $currency = '$';

        $country = new Country([
            'countries_iso_code_2' => 'US',
            'countries_iso_code_3' => 'USA',
            'countries_id'         => 1,
            'language'             => 'English',
            'languages'            => '{"en":"English"}',
            'currency'             => $currency
        ]);

        $this->assertSame($currency, $country->getCurrencyCode());
    }

    #[PreserveGlobalState(false)]
    #[RunInSeparateProcess]
    public function testGetCurrencyThrowsExceptionIfQuiqqerCurrencyNotInstalled(): void
    {
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

        $this->expectException(Exception::class);
        $country->getCurrency();
    }

    #[PreserveGlobalState(false)]
    #[RunInSeparateProcess]
    public function testGetCurrencyReturnsCurrencyObjectIfCurrencyExists(): void
    {
        $currencyCode = '$';

        Mockery::mock('overload:' . QUI::class)
            ->shouldReceive('getPackage')
            ->once()
            ->with('quiqqer/currency');

        $currencyMock = Mockery::mock(QUI\ERP\Currency\Currency::class);

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
    }

    #[PreserveGlobalState(false)]
    #[RunInSeparateProcess]
    public function testGetCurrencyReturnsDefaultCurrencyObjectIfCurrencyDoesNotExist(): void
    {
        $currencyCode = '$';

        Mockery::mock('alias:' . QUI::class)
            ->shouldReceive('getPackage')
            ->once()
            ->with('quiqqer/currency');

        $currencyHandlerMock = Mockery::mock('alias:' . QUI\ERP\Currency\Handler::class);

        $currencyHandlerMock->shouldReceive('getCurrency')
            ->once()
            ->with($currencyCode)
            ->andThrow(Mockery::mock(Exception::class));

        $currencyHandlerMock->shouldReceive('getDefaultCurrency')
            ->once()
            ->withNoArgs()
            ->andReturn(Mockery::mock(QUI\ERP\Currency\Currency::class));

        (new Country([
            'countries_iso_code_2' => 'US',
            'countries_iso_code_3' => 'USA',
            'countries_id'         => 1,
            'language'             => 'English',
            'languages'            => '{"en":"English"}',
            'currency'             => $currencyCode
        ]))->getCurrency();
    }

    #[PreserveGlobalState(false)]
    #[RunInSeparateProcess]
    public function testGetNameUsesGlobalLocaleIfNullProvided(): void
    {
        $localeMock = Mockery::mock(\QUI\Locale::class);
        $localeMock->shouldReceive('exists')->andReturnFalse();

        Mockery::mock('alias:' . QUI::class)
            ->shouldReceive('getLocale')
            ->once()
            ->withNoArgs()
            ->andReturn($localeMock);

        (new Country([
            'countries_iso_code_2' => 'US',
            'countries_iso_code_3' => 'USA',
            'countries_id'         => 1,
            'language'             => 'English',
            'languages'            => '{"en":"English"}',
            'currency'             => '$'
        ]))->getName();
    }

    #[PreserveGlobalState(false)]
    #[RunInSeparateProcess]
    public function testGetNameReturnsLocaleVariableIfItExists(): void
    {
        $expectedResult = 'My string from locale variable';

        $country = new Country([
            'countries_iso_code_2' => 'US',
            'countries_iso_code_3' => 'USA',
            'countries_id'         => 1,
            'language'             => 'English',
            'languages'            => '{"en":"English"}',
            'currency'             => '$'
        ]);

        $localeVariable = 'country.US';

        $localeMock = Mockery::mock(\QUI\Locale::class);
        $localeMock->shouldReceive('exists')
            ->with('quiqqer/countries', $localeVariable)
            ->andReturnTrue();

        $localeMock->shouldReceive('get')
            ->with('quiqqer/countries', $localeVariable)
            ->andReturn($expectedResult);

        Mockery::mock('alias:' . QUI::class)
            ->shouldReceive('getLocale')
            ->once()
            ->withNoArgs()
            ->andReturn($localeMock);

        $this->assertEquals($expectedResult, $country->getName());
    }

    #[PreserveGlobalState(false)]
    #[RunInSeparateProcess]
    public function testGetNameReturnsCountriesNameAttributeIfLocaleVariableDoesNotExist(): void
    {
        $expectedResult = 'TestCountry';

        $country = new Country([
            'countries_iso_code_2' => 'US',
            'countries_iso_code_3' => 'USA',
            'countries_id'         => 1,
            'language'             => 'English',
            'languages'            => '{"en":"English"}',
            'currency'             => '$',
            'countries_name'       => $expectedResult
        ]);

        $localeMock = Mockery::mock(\QUI\Locale::class);
        $localeMock->shouldReceive('exists')
            ->with('quiqqer/countries', 'country.US')
            ->andReturnFalse();

        Mockery::mock('alias:' . QUI::class)
            ->shouldReceive('getLocale')
            ->once()
            ->withNoArgs()
            ->andReturn($localeMock);

        $this->assertEquals($expectedResult, $country->getName());
    }

    public function testGetLangReturnsLanguageAttribute()
    {
        $expectedResult = 'TestLanguage';

        $country = new Country([
            'countries_iso_code_2' => 'US',
            'countries_iso_code_3' => 'USA',
            'countries_id'         => 1,
            'language'             => $expectedResult,
            'languages'            => '{"en":"English"}',
            'currency'             => '$'
        ]);

        $this->assertEquals($expectedResult, $country->getLang());
    }

    public function testGetLanguagesReturnsArrayOfLanguages()
    {
        $inputData = [
            [
                'foo'      => 'bar',
                'language' => 'EN',
                'lorem'    => 'ipsum'
            ],
            ['language' => 'DE'],
            [
                'language' => 'NL',
                'foo'      => 'bar'
            ]
        ];

        $expectedResult = ['EN', 'DE', 'NL'];

        $country = new Country([
            'countries_iso_code_2' => 'US',
            'countries_iso_code_3' => 'USA',
            'countries_id'         => 1,
            'language'             => 'English',
            'languages'            => json_encode($inputData),
            'currency'             => '$'
        ]);

        $this->assertEquals($expectedResult, $country->getLanguages());
    }

    public function testGetLocaleCodeReturnsWellFormattedCode()
    {
        $country = new Country([
            'countries_iso_code_2' => 'US',
            'countries_iso_code_3' => 'USA',
            'countries_id'         => 1,
            'language'             => 'EN',
            'languages'            => '{"en":"English"}',
            'currency'             => '$'
        ]);

        $this->assertEquals('en_US', $country->getLocaleCode());
    }

    public static function isEuReturnsTrueOnAllEuCountriesProvider(): iterable
    {
        $euCountryCodes = [
            'BE',
            'BG',
            'DK',
            'DE',
            'EE',
            'FI',
            'FR',
            'GR',
            'IE',
            'IT',
            'HR',
            'LV',
            'LT',
            'LU',
            'MT',
            'NL',
            'AT',
            'PL',
            'PT',
            'RO',
            'SE',
            'SK',
            'SI',
            'ES',
            'CZ',
            'HU',
            'CY'
        ];

        foreach ($euCountryCodes as $euCountryCode) {
            yield [
                new Country([
                    'countries_iso_code_2' => $euCountryCode,
                    'countries_iso_code_3' => 'USA',
                    'countries_id'         => 1,
                    'language'             => 'EN',
                    'languages'            => '{"en":"English"}',
                    'currency'             => '$'
                ])
            ];
        }
    }

    #[DataProvider('isEuReturnsTrueOnAllEuCountriesProvider')]
    public function testIsEuReturnsTrueOnAllEuCountries(Country $country): void
    {
        $this->assertTrue($country->isEU());
    }

    public function testIsEuReturnsFalseForNonEuCountry()
    {
        $country = new Country([
            'countries_iso_code_2' => 'US',
            'countries_iso_code_3' => 'USA',
            'countries_id'         => 1,
            'language'             => 'EN',
            'languages'            => '{"en":"English"}',
            'currency'             => '$'
        ]);

        $this->assertFalse($country->isEU());
    }
}
