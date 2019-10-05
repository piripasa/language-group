<?php

namespace App\Interfaces;

use App\Exceptions\Handler;

interface CountryConsoleInterface
{
    /**
     * Print data
     *
     * @param CountryServiceInterface $service
     * @param Handler $errorHandler
     * @param array $data
     * @return void
     */
    public function print(CountryServiceInterface $service, Handler $errorHandler, array $data): void;

    /**
     * Get request data serve it to the right service method
     *
     * @param CountryServiceInterface $service
     * @param array $data
     * @return ResponseInterface
     */
    public function serve(CountryServiceInterface $service, array $data): ResponseInterface;
}