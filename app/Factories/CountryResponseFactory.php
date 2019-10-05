<?php

namespace App\Factories;

use App\Interfaces\ResponseInterface;
use App\Responses\CountryResponse;

class CountryResponseFactory
{
    public static function create(array $data): ResponseInterface
    {
        return new CountryResponse($data);
    }
}