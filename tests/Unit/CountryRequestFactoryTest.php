<?php

namespace Tests\Unit;

use App\Factories\CountryRequestFactory;
use Tests\UnitTest;

class CountryRequestFactoryTest extends UnitTest
{
    public function testCreate()
    {
        $data = ['some data', 'some data'];
        $this->assertEquals($data, CountryRequestFactory::create($data)->get());
    }
}