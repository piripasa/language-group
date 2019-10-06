<?php

namespace Tests\Unit;

use App\Services\CountryApiService;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Tests\UnitTest;

class CountryApiServiceTest extends UnitTest
{
    protected $restApi;

    protected $apiResponseData;

    public function testGetCountry()
    {
        $countryName = 'Bangladesh';
        $responseJson = '[1,2,3]';

        $response = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $response->method('getBody')->will($this->returnValue($responseJson));

        $this->apiResponseData = [
            ['GET', sprintf('name/Bangladesh?fullText=true'), [], $response],
        ];

        $this->mockAPIs();

        $result = $this->restApi->getCountry($countryName);

        $this->assertEquals($responseJson, json_encode($result));
    }

    public function testGetCountryNotFound()
    {
        $countryName = 'Bangladesh';
        $responseJson = false;

        $response = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $response->method('getBody')->will($this->returnValue($responseJson));

        $this->apiResponseData = [
            ['GET', sprintf('name/Bangladesh?fullText=true'), [], $response],
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage($countryName . ' country not found!');

        $this->mockAPIs();
        $this->restApi->getCountry($countryName);

    }

    public function testCountriesSpeakLanguage()
    {
        $countryCode = 'bn';
        $responseJson = '[1,2,3]';

        $response = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $response->method('getBody')->will($this->returnValue($responseJson));

        $this->apiResponseData = [
            ['GET', sprintf('lang/bn'), [], $response],
        ];

        $this->mockAPIs();

        $result = $this->restApi->countriesSpeakLanguage($countryCode);

        $this->assertEquals($responseJson, json_encode($result));
    }

    public function testCountriesSpeakLanguageNotFound()
    {
        $languageCode = 'bn';
        $responseJson = false;
        $response = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $response->method('getBody')->will($this->returnValue($responseJson));
        $this->apiResponseData = [
            ['GET', sprintf('lang/bn'), [], $response],
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(sprintf('Language code %s not found!', $languageCode));

        $this->mockAPIs();
        $this->restApi->countriesSpeakLanguage($languageCode);
    }

    protected function mockAPIs()
    {
        $this->restApi = $this->createClassWithAbstractParams(CountryApiService::class, [ClientInterface::class], [
            ClientInterface::class => [
                'request' => $this->returnValueMap($this->apiResponseData)
            ]
        ]);
    }
}