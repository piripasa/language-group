<?php

namespace Tests\Unit;

use App\Requests\CountryRequest;
use Tests\UnitTest;

class CountryRequestTest extends UnitTest
{
    protected $request;

    public function setUp()
    {
        $this->request = new CountryRequest([1 => 'Bangladesh']);
    }

    public function testGet()
    {
        $result = $this->request->get();
        $this->assertEquals($result[1], 'Bangladesh');
    }

}