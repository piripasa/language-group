<?php

namespace Tests\Unit;

use App\Exceptions\Handler;
use Tests\UnitTest;

class ExceptionHandlerTest extends UnitTest
{
    protected $handler;

    public function setUp()
    {
        $this->handler = new Handler();
    }

    public function testGetErrorMessage()
    {
        $errorMessage = 'Custom error message';

        $error = $this->handler->getErrorMessage(new \Exception($errorMessage));
        $this->assertEquals(sprintf('%s%s', $errorMessage, PHP_EOL, PHP_EOL), $error);
    }
}