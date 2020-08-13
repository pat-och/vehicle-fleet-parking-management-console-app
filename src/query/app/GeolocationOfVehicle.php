<?php

declare(strict_types=1);


namespace App\query\app;


class GeolocationOfVehicle
{

    public string $vehicleId;
    public string $latitude;
    public string $longitude;

    public function __construct(string $vehicleId, string $latitude, string $longitude)
    {
        $this->vehicleId = $vehicleId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}