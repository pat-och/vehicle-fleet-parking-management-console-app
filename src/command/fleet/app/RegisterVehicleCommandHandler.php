<?php

declare(strict_types=1);


namespace App\command\fleet\app;


use App\command\fleet\infra\FleetRepositoryInterface;
use Exception;

class RegisterVehicleCommandHandler
{

    private FleetRepositoryInterface $fleetRepository;
    private RegisterVehicleCommandResponse $registerVehicleCommandResponse;

    public function __construct(FleetRepositoryInterface $fleetRepository,
                                RegisterVehicleCommandResponse $registerVehicleCommandResponse)
    {
        $this->fleetRepository = $fleetRepository;
        $this->registerVehicleCommandResponse = $registerVehicleCommandResponse;
    }

    public function __invoke(RegisterVehicleCommand $registerVehicleCommand): void
    {
        $fleet = $this->fleetRepository->getFleet($registerVehicleCommand->getUserId());

        try {
            $fleet->registerVehicle($registerVehicleCommand->getVehicleRegistrationNumber());
        } catch (Exception $e) {
            $this->registerVehicleCommandResponse->setError($e->getMessage());
        }
    }

}