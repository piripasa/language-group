<?php

namespace Tests\Unit;

use App\Responses\CountryResponse;
use Tests\UnitTest;

class CountryResponseTest extends UnitTest
{
    protected $response;

    protected $data = [
        'some data'
    ];

    public function setUp()
    {
        $this->response = new CountryResponse($this->data);
    }

    public function testGet()
    {
        $result = $this->response->get();

        $this->assertEquals(sprintf('%s%s', implode(PHP_EOL, $this->data), PHP_EOL), $result);
    }
}