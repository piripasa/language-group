<?php

use App\Console\CountryConsole;
use App\Interfaces\CountryApiInterface;
use App\Interfaces\CountryConsoleInterface;
use App\Interfaces\CountryRepositoryInterface;
use App\Interfaces\CountryServiceInterface;
use App\Repositories\CountryRepository;
use App\Services\CountryApiService;
use App\Services\CountryService;
use GuzzleHttp\Client;

$apiConfig = require_once __DIR__ . '/api.php';

return [
    'bindings' => [
        CountryConsoleInterface::class => CountryConsole::class,
        CountryServiceInterface::class => CountryService::class,
        CountryRepositoryInterface::class => CountryRepository::class,
        CountryApiInterface::class => function ($app) use ($apiConfig) {

            return $app->makeWith(CountryApiService::class, [
                'client' => $app->makeWith(Client::class, [
                    'config' => [
                        'base_uri' => $apiConfig['api']['base_url']
                    ]
                ])
            ]);
        }
    ],
];