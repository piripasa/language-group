<?php

namespace App\Services;

use App\Factories\CountryResponseFactory;
use App\Interfaces\CountryRepositoryInterface;
use App\Interfaces\CountryServiceInterface;
use App\Interfaces\RequestInterface;
use App\Interfaces\ResponseInterface;

class CountryService implements CountryServiceInterface
{
    protected $repository;

    /**
     * Inject repository
     *
     * @param CountryRepositoryInterface $repository
     */
    public function __construct(CountryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Call Repository and get data using country name
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function getCountryName(RequestInterface $request): ResponseInterface
    {
        $countryName = $request->get()[1];

        $countryCode = $this->repository->getCountryCode($countryName);

        $countries = $this->repository->getCountriesSpeakingSameLanguage($countryCode, $countryName);
        
        //var_dump($countries);
        return CountryResponseFactory::create([
            'country_code' => sprintf('Country language code: %s', $countryCode),
            'countries' => sprintf('%s speaks same language with these countries: %s', $countryName, implode(', ', $countries))
        ]);
    }

    /**
     * Check if the given two countries speak the same languages or not
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function checkTalkingLanguage(RequestInterface $request): ResponseInterface
    {
        $firstCountryName = $request->get()[1];
        $secondCountryName = $request->get()[2];

        $firstCountryCode = $this->repository->getCountryCode($firstCountryName);

        $secondCountryCode = $this->repository->getCountryCode($secondCountryName);

        return CountryResponseFactory::create([
            sprintf('%s and %s %s the same language.',
                $firstCountryName, $secondCountryName,
                $firstCountryCode !== $secondCountryCode ? 'do not speak' : 'speak')
        ]);
    }

}