<?php

namespace Tests\Unit;

use App\Factories\CountryResponseFactory;
use Tests\UnitTest;

class CountryResponseFactoryTest extends UnitTest
{
    public function testCreate()
    {
        $data = ['some data', 'some data'];
        $this->assertEquals(sprintf('%s%s',implode(PHP_EOL, $data), PHP_EOL), CountryResponseFactory::create($data)->get());
    }
}