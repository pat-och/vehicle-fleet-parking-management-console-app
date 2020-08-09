<?php

declare(strict_types=1);


namespace App\command\fleet\app;


use App\command\fleet\infra\FleetRepositoryInterface;
use Exception;

class ParkVehicleCommandHandler
{

    private FleetRepositoryInterface $fleetRepository;
    private ParkVehicleCommandResponse $parkVehicleCommandResponse;

    public function __construct(FleetRepositoryInterface $fleetRepository,
                                ParkVehicleCommandResponse $parkVehicleCommandResponse)
    {
        $this->fleetRepository = $fleetRepository;
        $this->parkVehicleCommandResponse = $parkVehicleCommandResponse;
    }

    public function __invoke(ParkVehicleCommand $parkVehicleCommand): void
    {
        $fleet = $this->fleetRepository->getFleet($parkVehicleCommand->getUserId());
        $vehicle = $fleet->getVehicle($parkVehicleCommand->getVehicleRegistrationNumber());

        try {
            $vehicle->setGeolocation($parkVehicleCommand->getGeoLocation());
        } catch (Exception $e) {
            $this->parkVehicleCommandResponse->setError($e->getMessage());
        }
    }
}