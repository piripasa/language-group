<?php

namespace App\Interfaces;

interface CountryApiInterface
{
    /**
     * Get the country by given country name
     *
     * @param string $countryName
     * @return array
     */
    public function getCountry(string $countryName): array;

    /**
     * Get the list of countries speak a language by language code
     *
     * @param string $languageCode
     * @return array
     */
    public function countriesSpeakLanguage(string $languageCode): array;
}