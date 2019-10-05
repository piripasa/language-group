<?php

namespace App\Services;

use App\Interfaces\CountryApiInterface;
use GuzzleHttp\ClientInterface;

class CountryApiService implements CountryApiInterface
{
    private $guzzleClient;

    /**
     * Inject Http client
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->guzzleClient = $client;
    }

    /**
     * Get the country by given country name
     *
     * @param string $countryName
     * @return array
     */
    public function getCountry(string $countryName): array
    {
        $response = $this->guzzleClient->request('GET', sprintf('name/%s?fullText=true', $countryName));

        $country = json_decode($response->getBody(), 1);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception(sprintf('%s country not found!', $countryName));
        }

        return $country;
    }

    /**
     * Get the list of countries speak a language by language code
     *
     * @param string $languageCode
     * @return array
     */
    public function countriesSpeakLanguage(string $languageCode): array
    {
        $response = $this->guzzleClient->request('GET', sprintf('lang/%s', $languageCode));

        $countries = json_decode($response->getBody(), 1);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception(sprintf('Language code %s not found!', $languageCode));
        }

        return $countries;
    }
}