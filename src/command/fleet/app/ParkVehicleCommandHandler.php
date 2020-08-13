<?php

declare(strict_types=1);


namespace App\command\fleet\app;


use App\command\fleet\infra\FleetRepositoryInterface;
use App\command\shared\app\CommandHandler;
use App\command\shared\app\CommandResponse;
use Exception;

class ParkVehicleCommandHandler extends CommandHandler
{
    private FleetRepositoryInterface $fleetRepository;

    public function __construct(FleetRepositoryInterface $fleetRepository,
                                CommandResponse $commandResponse)
    {
        $this->fleetRepository = $fleetRepository;
        parent::__construct($commandResponse);
    }

    public function handle(ParkVehicleCommand $parkVehicleCommand): void
    {
        $fleet = $this->fleetRepository->getFleet($parkVehicleCommand->getUserId());
        $vehicle = $fleet->getVehicle($parkVehicleCommand->getVehicleRegistrationNumber());

        try {
            $vehicle->setGeolocation($parkVehicleCommand->getGeoLocation());
        } catch (Exception $e) {
            $this->getCommandResponse()->setError($e->getMessage());
        }
    }
}