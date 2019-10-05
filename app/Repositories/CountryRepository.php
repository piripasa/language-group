<?php

namespace App\Repositories;

use App\Interfaces\CountryApiInterface;
use App\Interfaces\CountryRepositoryInterface;

class CountryRepository implements CountryRepositoryInterface
{
    protected $restApi;

    /**
     * Inject API
     *
     * @param CountryApiInterface $restApi
     */
    public function __construct(CountryApiInterface $restApi)
    {
        $this->restApi = $restApi;
    }

    /**
     * Get the country code by country name
     *
     * @param string $countryName
     * @return string
     */
    public function getCountryCode(string $countryName): string
    {
        $country = $this->restApi->getCountry($countryName);

        if (empty($country[0]['languages'][0]['iso639_1'])) {
            throw new \Exception(sprintf('%s country not found!', $countryName));
        }

        return $country[0]['languages'][0]['iso639_1'];
    }

    /**
     * Get the list of countries speak a language by country code and country name
     *
     * @param string $countryCode
     * @param string $countryName
     * @return void
     */
    public function getCountriesSpeakingSameLanguage(string $countryCode, string $countryName)
    {
        $otherCountries = $this->restApi->countriesSpeakLanguage($countryCode);

        $countries = [];

        foreach ($otherCountries as $otherCountry) {

            if ($otherCountry['name'] === $countryName) {
                continue;
            }

            $countries[] = $otherCountry['name'];
        }

        return $countries;
    }

}