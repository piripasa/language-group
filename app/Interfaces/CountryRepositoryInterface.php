<?php

namespace App\Interfaces;

interface CountryRepositoryInterface
{
    /**
     * Get the country code by country name
     *
     * @param string $countryName
     * @return string
     */
    public function getCountryCode(string $countryName): string;

    /**
     * Get the list of countries speak a language by country code and country name
     *
     * @param string $countryCode
     * @param string $countryName
     * @return void
     */
    public function getCountriesSpeakingSameLanguage(string $countryCode, string $countryName);
}