<?php

use App\Interfaces\CountryServiceInterface;
use App\Interfaces\RequestInterface;

/**
 * 1 refers to the 1st parameter as country name in the command line
 * 2 refers to the 2nd  parameter as country name for checking with 1st one
 */
return [
    1 => function (CountryServiceInterface $service, RequestInterface $request) {
        return $service->getCountryName($request);
    },
    2 => function (CountryServiceInterface $service, RequestInterface $request) {
        return $service->checkTalkingLanguage($request);
    },
];