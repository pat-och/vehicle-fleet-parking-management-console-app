<?php

declare(strict_types=1);


namespace App\command\fleet\app;


use App\command\fleet\domain\Geolocation;

class ParkVehicleCommand
{

    private string $userId;
    private string $vehicleRegistrationNumber;
    private Geolocation $geolocation;

    public function __construct(string $userId, string $vehicleRegistrationNumber, Geolocation $geolocation)
    {
        $this->userId = $userId;
        $this->vehicleRegistrationNumber = $vehicleRegistrationNumber;
        $this->geolocation = $geolocation;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getVehicleRegistrationNumber(): string
    {
        return $this->vehicleRegistrationNumber;
    }

    public function getGeoLocation(): Geolocation
    {
        return $this->geolocation;
    }


}