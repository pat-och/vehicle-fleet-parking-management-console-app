<?php

declare(strict_types=1);


namespace App\command\fleet\domain;


class Geolocation
{

    private string $latitude;
    private string $longitude;

    public function __construct(string $latitude, string $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}