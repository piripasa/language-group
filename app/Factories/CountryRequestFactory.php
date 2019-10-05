<?php

namespace App\Factories;

use App\Interfaces\RequestInterface;
use App\Requests\CountryRequest;

class CountryRequestFactory
{
    public static function create(array $data): RequestInterface
    {
        return new CountryRequest($data);
    }
}