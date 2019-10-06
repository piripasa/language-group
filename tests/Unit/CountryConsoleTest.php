<?php

namespace Tests\Unit;

use App\Console\CountryConsole;
use App\Exceptions\Handler;
use App\Interfaces\CountryServiceInterface;
use App\Interfaces\RequestInterface;
use App\Interfaces\ResponseInterface;
use Tests\UnitTest;

class CountryConsoleTest extends UnitTest
{
    protected $countryConsole;

    protected $countryRequestMock;

    protected $countryServiceMock;

    protected $countryResponseMock;

    protected $errorHandlerMock;

    public function setUp()
    {
        $this->countryConsole = new CountryConsole([
            1 => function (CountryServiceInterface $service, RequestInterface $request) {
                return $service->getCountryName($request);
            },
            2 => function (CountryServiceInterface $service, RequestInterface $request) {
                return $service->checkTalkingLanguage($request);
            },
        ]);
        $this->countryServiceMock = $this->getMockBuilder(CountryServiceInterface::class)->disableOriginalConstructor()->getMock();
        $this->errorHandlerMock = $this->getMockBuilder(Handler::class)->getMock();
        $this->countryResponseMock = $this->getMockBuilder(ResponseInterface::class)->getMock();
    }

    public function testPrint()
    {
        $responseText = 'Dummy text for response';
        $this->countryConsole = $this->getMockBuilder(CountryConsole::class)->setMethods(['serve'])->disableOriginalConstructor()->getMock();
        $this->countryResponseMock->method('get')->willReturn($responseText);
        $this->countryConsole->expects($this->once())->method('serve')->willReturn($this->countryResponseMock);

        ob_start();
        $this->countryConsole->print($this->countryServiceMock, $this->errorHandlerMock, ['index.php', 'Germany']);
        $result = ob_get_contents();
        ob_end_clean();

        $this->assertEquals($responseText, $result);
    }

    public function testServe()
    {
        $result = $this->countryConsole->serve($this->countryServiceMock, [1 => 'Germany']);

        $this->assertInstanceOf(ResponseInterface::class, $result);
    }

    public function testServeRequestItemsEmpty()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Your command syntax must follow this schema "php index.php [string country_name] [OPTIONAL string second_country_name]"');

        $this->countryConsole->serve($this->countryServiceMock, []);
    }

    public function testServeRequestItemsNotFound()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Your command syntax must follow this schema "php index.php [string country_name] [OPTIONAL string second_country_name]"');

        $this->countryConsole->serve($this->countryServiceMock, ['Austria', 'Belgium', 'Holy See', 'Liechtenstein', 'Luxembourg', 'Switzerland']);
    }

    public function testHandleError()
    {
        $exceptionText = 'dummy exception text';
        $this->errorHandlerMock->method('getErrorMessage')->will($this->returnValue('Error: ' . $exceptionText));
        $this->countryConsole = $this->getMockBuilder(CountryConsole::class)->disableOriginalConstructor()->setMethods(['serve'])->getMock();
        $this->countryConsole->expects($this->once())->method('serve')->will($this->throwException(new \Exception($exceptionText)));

        ob_start();
        $this->countryConsole->print($this->countryServiceMock, $this->errorHandlerMock, ['index.php', 'Wrong Country Name']);
        $result = ob_get_contents();
        ob_end_clean();

        $this->assertEquals('Error: ' . $exceptionText, $result);
    }
}