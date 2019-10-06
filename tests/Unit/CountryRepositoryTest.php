<?php

namespace Tests\Unit;

use App\Interfaces\CountryApiInterface;
use App\Repositories\CountryRepository;
use Tests\UnitTest;

class CountryRepositoryTest extends UnitTest
{
    protected $repository;

    protected $getCountryValues = [
        ['Bangladesh',
            [
                [
                    'languages' => [
                        ['iso639_1' => 'bn']
                    ]
                ]
            ]
        ],
        ['Wrong country name', []],
    ];

    protected $countriesSpeakingLanguageValues = [
        [
            'de',
            [
                ['name' => 'Austria'],
                ['name' => 'Belgium'],
                ['name' => 'Holy See'],
                ['name' => 'Liechtenstein'],
                ['name' => 'Luxembourg'],
                ['name' => 'Switzerland']
            ]
        ],
        ['Wrong language code', []]
    ];

    protected function setUp()
    {
        $this->repository = $this->createClassWithAbstractParams(CountryRepository::class, [CountryApiInterface::class], [
            CountryApiInterface::class => [
                'getCountry' => $this->returnValueMap($this->getCountryValues),
                'countriesSpeakLanguage' => $this->returnValueMap($this->countriesSpeakingLanguageValues),
            ]
        ]);
    }

    public function testGetCountryCode()
    {
        $result = $this->repository->getCountryCode('Bangladesh');
        $this->assertEquals('bn', $result);
    }

    public function testGetCountryCodeNotFoundError()
    {
        $countryName = 'Wrong country name';
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(sprintf('%s country not found!', $countryName));

        $this->repository->getCountryCode('Wrong country name');
     }

    public function testGetCountriesSpeakingSameLanguage()
    {
        $result = $this->repository->getCountriesSpeakingSameLanguage('de', 'Germany');

        $this->assertTrue(is_array($result));
        $this->assertEquals('["Austria","Belgium","Holy See","Liechtenstein","Luxembourg","Switzerland"]', json_encode($result));
    }

    public function testGetCountriesSpeakingSameLanguageNotFoundError()
    {
        $wrongCountryName = 'Wrong country name';
        $wrongCountryCode = 'Wrong language code';

        $actual = $this->repository->getCountriesSpeakingSameLanguage($wrongCountryCode, $wrongCountryName);

        $this->assertTrue(empty($actual));
    }
}