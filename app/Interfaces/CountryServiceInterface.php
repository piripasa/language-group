<?php

namespace App\Interfaces;

interface CountryServiceInterface
{
    /**
     * Call Repository and get data using country name
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function getCountryName(RequestInterface $request): ResponseInterface;

    /**
     * Check if the given two countries speak the same languages or not
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function checkTalkingLanguage(RequestInterface $request): ResponseInterface;
}