<?php

declare(strict_types=1);


namespace App\command\fleet\domain;


use Exception;

class Vehicle
{

    private string $registrationNumber;
    private ?Geolocation $geolocation;

    public function __construct(string $registrationNumber, Geolocation $geolocation = null)
    {
        $this->registrationNumber = $registrationNumber;
        $this->geolocation = $geolocation;
    }

    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }

    public function setGeolocation(Geolocation $geolocation): void
    {
        if ($geolocation === $this->geolocation) {
            throw new Exception('This vehicle is already parked at this location.');
        }

        $this->geolocation = $geolocation;
    }
}