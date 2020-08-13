<?php

declare(strict_types=1);


namespace App\query\infra;


use App\query\app\FleetQueryHandlerInterface;
use App\query\app\GeolocationOfVehicle;
use App\Repository\FleetRepository;

class DoctrineFleetQueryHandler implements FleetQueryHandlerInterface
{

    private FleetRepository $fleetRepository;

    public function __construct(FleetRepository $fleetRepository)
    {
        $this->fleetRepository = $fleetRepository;
    }


    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }

    public function locateVehicle(string $vehicleRegistrationNumber, string $fleetId): ?GeolocationOfVehicle
    {
        $fleet = $this->fleetRepository->findOneBy(array('uuid' => $fleetId));

        print_r($fleet->getUuid());


        if (!isset($fleet)) {
            return null;
        }

        $vehicles = $fleet->getVehicles();

        if (!isset($vehicles)) {
            return null;
        }

        foreach ($vehicles as $vehicle) {
            if ($vehicleRegistrationNumber === $vehicle->getRegistrationNumber()) {
                return new GeolocationOfVehicle(
                    $vehicle->getUuid(),
                    $vehicle->getLatitude(),
                    $vehicle->getLongitude()
                );
            }

        }

    }
}