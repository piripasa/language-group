<?php

namespace App\Requests;

use App\Interfaces\RequestInterface;

class CountryRequest implements RequestInterface
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function get(): array
    {
        return $this->data;
    }
}