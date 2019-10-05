<?php

namespace App\Console;

use App\Exceptions\Handler;
use App\Factories\CountryRequestFactory;
use App\Interfaces\CountryConsoleInterface;
use App\Interfaces\CountryServiceInterface;
use App\Interfaces\ResponseInterface;

class CountryConsole implements CountryConsoleInterface
{
    protected $countryServiceMapper = [];

    /**
     * Constructor
     *
     * @param array $serviceMapper
     */
    public function __construct(array $serviceMapper)
    {
        $this->countryServiceMapper = $serviceMapper;
    }

    /**
     * Print data
     *
     * @param CountryServiceInterface $service
     * @param Handler $errorHandler
     * @param array $data
     * @return void
     */
    public function print(CountryServiceInterface $service, Handler $errorHandler, array $data): void
    {
        try {
            echo $this->serve($service, $data)->get();
        } catch (\Exception $e) {
            echo $errorHandler->getErrorMessage($e);
        }
    }

    /**
     * Get request data serve it to the right service method
     *
     * @param CountryServiceInterface $service
     * @param array $data
     * @return ResponseInterface
     */
    public function serve(CountryServiceInterface $service, array $data): ResponseInterface
    {
        unset($data[0]);

        if (empty($this->countryServiceMapper[sizeof($data)])) {
            throw new \Exception('Your command syntax must follow this schema "php index.php [string country_name] [OPTIONAL string second_country_name]"');
        }

        return $this->countryServiceMapper[sizeof($data)]($service, CountryRequestFactory::create($data));
    }

}