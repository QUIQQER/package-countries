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

class CountryTest extends TestCase
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
}
