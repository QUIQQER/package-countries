<?php

namespace QUI\Countries;

use Mockery;
use PHPUnit\Framework\Attributes\PreserveGlobalState;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\TestCase;
use QUI;
use stdClass;

final class ManagerTest extends TestCase
{
    public function testIsCountryWithCountryObject(): void
    {
        $country = new Country([
            'countries_iso_code_2' => 'US',
            'countries_iso_code_3' => 'USA',
            'countries_id'         => 1,
            'language'             => 'EN',
            'languages'            => '{"en":"English"}',
            'currency'             => '$'
        ]);

        $this->assertTrue(Manager::isCountry($country));
    }

    public function testIsCountryWithNonCountryObject(): void
    {
        $this->assertFalse(Manager::isCountry(new stdClass()));
    }

//    #[PreserveGlobalState(false)]
//    #[RunInSeparateProcess]
//    public function testGetDefaultCountryReturnsDeIfConfigFails(): void
//    {
//        Mockery::mock('alias:' . QUI::class)
//            ->shouldReceive('conf')
//            ->once()
//            ->andThrows(QUI\Exception::class);
//
//        $this->assertEquals('de', Manager::getDefaultCountry());
//    }

    #[PreserveGlobalState(false)]
    #[RunInSeparateProcess]
    public function testGetReturnsCountryFromDatabase(): void
    {
        $databaseMock = Mockery::mock(QUI\Database\DB::class);
        $databaseMock->shouldReceive('fetch')
            ->once()
            ->andReturn([
                [
                    'countries_iso_code_2' => 'US',
                    'countries_iso_code_3' => 'USA',
                    'countries_id'         => 1,
                    'language'             => 'EN',
                    'languages'            => '{"en":"English"}',
                    'currency'             => '$'
                ]
            ]);

        $quiMock = Mockery::mock('alias:' . QUI::class);

        $quiMock->shouldReceive('getDatabase')
            ->andReturn($databaseMock);

        $quiMock->shouldReceive('getDBTableName')
            ->andReturn('foo');

        $this->assertEquals(
            'US',
            Manager::get('us')->getCode()
        );
    }

    #[PreserveGlobalState(false)]
    #[RunInSeparateProcess]
    public function testGetThrowsExceptionIfCountryDoesNotExist(): void
    {
        $databaseMock = Mockery::mock(QUI\Database\DB::class);
        $databaseMock->shouldReceive('fetch')
            ->once()
            ->andReturn([]);

        $localeMock = Mockery::mock(QUI\Locale::class);
        $localeMock->shouldReceive('get')
            ->andReturn('foo');

        $quiMock = Mockery::mock('alias:' . QUI::class);

        $quiMock->shouldReceive('getDatabase')
            ->andReturn($databaseMock);

        $quiMock->shouldReceive('getDBTableName')
            ->andReturn('foo');

        $quiMock->shouldReceive('getLocale')
            ->andReturn($localeMock);

        $this->expectException(QUI\Exception::class);
        Manager::get('foo');
    }

    #[PreserveGlobalState(false)]
    #[RunInSeparateProcess]
    public function testGetCompleteListReturnsEmptyOnException(): void
    {
        $databaseMock = Mockery::mock(QUI\Database\DB::class);
        $databaseMock->shouldReceive('fetch')
            ->once()
            ->andReturn([]);

        $quiMock = Mockery::mock('alias:' . QUI::class);

        $quiMock->shouldReceive('getDatabase')
            ->andReturn($databaseMock);

        $quiMock->shouldReceive('getDBTableName')
            ->andReturn('foo');

        $this->assertEmpty(Manager::getCompleteList());
    }

    #[PreserveGlobalState(false)]
    #[RunInSeparateProcess]
    public function testGetCompleteListReturnsArrayOfCountriesInTheDatabase(): void
    {
        $databaseMock = Mockery::mock(QUI\Database\DB::class);
        $databaseMock->shouldReceive('fetch')
            ->once()
            ->andReturn([
                [
                    'countries_iso_code_2' => 'US',
                    'countries_iso_code_3' => 'USA',
                    'countries_id'         => 1,
                    'language'             => 'EN',
                    'languages'            => '{"en":"English"}',
                    'currency'             => '$'
                ],
                [
                    'countries_iso_code_2' => 'DE',
                    'countries_iso_code_3' => 'GER',
                    'countries_id'         => 1,
                    'language'             => 'DE',
                    'languages'            => '{"de":"German"}',
                    'currency'             => '€'
                ]
            ]);

        $localeMock = Mockery::mock(QUI\Locale::class);
        $localeMock->shouldReceive('get')
            ->andReturn('foo');

        $quiMock = Mockery::mock('alias:' . QUI::class);

        $quiMock->shouldReceive('getDatabase')
            ->andReturn($databaseMock);

        $quiMock->shouldReceive('getDBTableName')
            ->andReturn('foo');

        $quiMock->shouldReceive('getLocale')
            ->andReturn($localeMock);

        $countries = Manager::getList();

        $this->assertCount(2, $countries);
        $this->assertEquals('US', $countries[0]->getCode());
        $this->assertEquals('DE', $countries[1]->getCode());
    }

    #[PreserveGlobalState(false)]
    #[RunInSeparateProcess]
    public function testGetListReturnsEmptyOnException(): void
    {
        $databaseMock = Mockery::mock(QUI\Database\DB::class);
        $databaseMock->shouldReceive('fetch')
            ->once()
            ->andReturn([]);

        $quiMock = Mockery::mock('alias:' . QUI::class);

        $quiMock->shouldReceive('getDatabase')
            ->andReturn($databaseMock);

        $quiMock->shouldReceive('getDBTableName')
            ->andReturn('foo');

        $this->assertEmpty(Manager::getCompleteList());
    }

    #[PreserveGlobalState(false)]
    #[RunInSeparateProcess]
    public function testGetListReturnsArrayOfCountriesInTheDatabase(): void
    {
        $databaseMock = Mockery::mock(QUI\Database\DB::class);
        $databaseMock->shouldReceive('fetch')
            ->once()
            ->andReturn([
                [
                    'countries_iso_code_2' => 'US',
                    'countries_iso_code_3' => 'USA',
                    'countries_id'         => 1,
                    'language'             => 'EN',
                    'languages'            => '{"en":"English"}',
                    'currency'             => '$'
                ],
                [
                    'countries_iso_code_2' => 'DE',
                    'countries_iso_code_3' => 'GER',
                    'countries_id'         => 1,
                    'language'             => 'DE',
                    'languages'            => '{"de":"German"}',
                    'currency'             => '€'
                ]
            ]);

        $localeMock = Mockery::mock(QUI\Locale::class);
        $localeMock->shouldReceive('get')
            ->andReturn('foo');

        $quiMock = Mockery::mock('alias:' . QUI::class);

        $quiMock->shouldReceive('getDatabase')
            ->andReturn($databaseMock);

        $quiMock->shouldReceive('getDBTableName')
            ->andReturn('foo');

        $quiMock->shouldReceive('getLocale')
            ->andReturn($localeMock);

        $countries = Manager::getList();

        $this->assertCount(2, $countries);
        $this->assertEquals('US', $countries[0]->getCode());
        $this->assertEquals('DE', $countries[1]->getCode());
    }

    public function testSortedListReturnsSortedArrayOfCountriesInTheDatabase(): void
    {
        $this->markTestIncomplete(
            'Figure out how to test with that many dependencies and side-effects'
        );
    }

    public function testGetAllCountryCodes(): void
    {
        $this->markTestIncomplete(
            'Figure out how to test with the side-effects of this method'
        );
    }

    #[PreserveGlobalState(false)]
    #[RunInSeparateProcess]
    public function testExistsCountryCode(): void
    {
        $this->markTestIncomplete(
            'Figure out how to test with the side-effects of this method'
        );
    }
}
