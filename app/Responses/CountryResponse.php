<?php

namespace App\Responses;

use App\Interfaces\ResponseInterface;

class CountryResponse implements ResponseInterface
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function get(): string
    {
        return sprintf('%s%s', implode(PHP_EOL, $this->data), PHP_EOL);
    }
}