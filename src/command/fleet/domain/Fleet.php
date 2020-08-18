<?php

declare(strict_types=1);


namespace App\command\fleet\domain;



use Exception;

class Fleet
{

    private string $userId;
    private array $vehicles = array();

    public function __construct(string $userId, array $vehicles = [])
    {
        $this->userId = $userId;
        $this->vehicles = $vehicles;
    }

    public function getVehicles(): array
    {
        return $this->vehicles;
    }

    public function registerVehicle(string $registrationNumber, Geolocation $geolocation = null): void
    {

        $vehicle = new Vehicle($registrationNumber, $geolocation);

        if (array_key_exists($registrationNumber, $this->vehicles)) {
            throw new Exception('this vehicle has already been registered into your fleet');
        }

        $this->vehicles[$registrationNumber] = $vehicle;
    }

    public function getVehicle(string $registrationNumber): ?Vehicle
    {
        foreach ($this->vehicles as $vehicle) {
            if ($registrationNumber === $vehicle->getRegistrationNumber()) {
                return $vehicle;
            }
        }

        return null;
    }

    public function getId()
    {
        return $this->userId;
    }
}