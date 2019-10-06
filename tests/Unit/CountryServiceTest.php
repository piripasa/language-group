<?php

namespace Tests\Unit;

use App\Interfaces\RequestInterface;
use App\Interfaces\ResponseInterface;
use App\Repositories\CountryRepository;
use App\Services\CountryService;
use Tests\UnitTest;

class CountryServiceTest extends UnitTest
{
    protected $getCountryCodeResponse;

    protected $service;

    protected $requestMock;

    public function testGetCountryName()
    {
        $this->getCountryCodeResponse = [
            ['Germany', 'de']
        ];

        $this->createRequestMock();

        $this->requestMock->method('get')->will($this->returnValue([
            1 => 'Germany'
        ]));

        $this->requestMock->method('get')->will($this->returnValue([1 => 'Germany']));

        $result = $this->service->getCountryName($this->requestMock);

        $this->assertInstanceOf(ResponseInterface::class, $result);

        $this->assertEquals(sprintf('Country language code: de%sGermany speaks same language with these countries: Austria, Belgium, Holy See, Liechtenstein, Luxembourg, Switzerland%s', PHP_EOL, PHP_EOL), $result->get());
    }

    public function testCheckTalkingLanguageNotMatch()
    {
        $this->getCountryCodeResponse = [
            ['Bangladesh', 'bn'],
            ['Germany', 'de']
        ];

        $this->createRequestMock();

        $this->requestMock->method('get')->will($this->returnValue([
            1 => 'Bangladesh',
            2 => 'Germany'
        ]));

        $result = $this->service->checkTalkingLanguage($this->requestMock);

        $this->assertInstanceOf(ResponseInterface::class, $result);

        $this->assertEquals(sprintf('Bangladesh and Germany do not speak the same language.%s', PHP_EOL), $result->get());

    }

    public function testCheckSpeakingLanguageMatch()
    {
        $this->getCountryCodeResponse = [
            ['Austria', 'de'],
            ['Germany', 'de']
        ];

        $this->createRequestMock();

        $this->requestMock->method('get')->will($this->returnValue([
            1 => 'Austria',
            2 => 'Germany'
        ]));

        $result = $this->service->checkTalkingLanguage($this->requestMock);

        $this->assertInstanceOf(ResponseInterface::class, $result);

        $this->assertEquals(sprintf('Austria and Germany speak the same language.%s',PHP_EOL), $result->get());

    }

    protected function createRequestMock()
    {
        $this->service = $this->createClassWithAbstractParams(CountryService::class, [
            CountryRepository::class,
        ], [
            CountryRepository::class => [
                'getCountryCode' => $this->returnValueMap($this->getCountryCodeResponse),
                'getCountriesSpeakingSameLanguage' => ['Austria', 'Belgium', 'Holy See', 'Liechtenstein', 'Luxembourg', 'Switzerland'],
            ]
        ]);

        $this->requestMock = $this->getMockBuilder(RequestInterface::class)->getMock();
    }
}