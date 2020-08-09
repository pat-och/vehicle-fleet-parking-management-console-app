<?php

declare(strict_types=1);


namespace App\command\fleet\infra;


use App\command\fleet\domain\Fleet;
use App\command\fleet\domain\Geolocation;

interface FleetRepositoryInterface
{
    public function addFleet(string $userId): void;
    public function getFleet(string $userId): ?Fleet;
    public function addVehicleToFleet(string $vehicleRegistrationNumber, string $userId, Geolocation $geolocation = null): void;
}