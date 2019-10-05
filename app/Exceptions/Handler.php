<?php

namespace App\Exceptions;

use GuzzleHttp\Exception\ClientException;

class Handler
{
    /**
     * Handle several types of exception
     *
     * @param \Exception $exception
     * @return string
     */
    public function getErrorMessage(\Exception $exception): string
    {
        switch (get_class($exception)) {

            case ClientException::class:
                $errorMessage = $this->getAPIRequestErrors($exception);
                break;
            default:
                $errorMessage = $exception->getMessage();
                break;
        }

        return sprintf('%s%s', $errorMessage, PHP_EOL);
    }

    /**
     * Handle exceptions that comes from Guzzle Http client
     *
     * @param ClientException $exception
     * @return string
     */
    protected function getAPIRequestErrors(ClientException $exception): string
    {
        $uri = $exception->getRequest()->getRequestTarget();

        $errorBody = json_decode($exception->getResponse()->getBody(), 1);
        $errorMessage = $errorBody['message'];

        if (json_last_error() !== JSON_ERROR_NONE) {
            $errorMessage = 'Something went wrong please try again later!';
        }

        return sprintf('The api response for the uri "%s" is "%s"', $uri, $errorMessage);
    }
}