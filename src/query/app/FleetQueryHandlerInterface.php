<?php

declare(strict_types=1);


namespace App\query\app;




interface FleetQueryHandlerInterface
{
    public function getAll(): array;
    public function locateVehicle(string $fooVehicleRegistrationNumber, string $barFleetId): ?GeolocationOfVehicle;
}