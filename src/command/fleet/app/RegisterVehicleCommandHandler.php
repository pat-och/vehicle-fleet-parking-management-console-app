<?php

declare(strict_types=1);


namespace App\command\fleet\app;


use App\command\fleet\infra\FleetRepositoryInterface;
use App\command\shared\app\CommandHandler;
use App\command\shared\app\CommandResponse;
use Exception;

class RegisterVehicleCommandHandler extends CommandHandler
{

    private FleetRepositoryInterface $fleetRepository;

    public function __construct(FleetRepositoryInterface $fleetRepository, CommandResponse $commandResponse)
    {
        $this->fleetRepository = $fleetRepository;
        parent::__construct($commandResponse);
    }

    public function __invoke(RegisterVehicleCommand $registerVehicleCommand): void
    {
        $fleet = $this->fleetRepository->getFleet($registerVehicleCommand->getUserId());

        try {
            $fleet->registerVehicle($registerVehicleCommand->getVehicleRegistrationNumber());

            $this->fleetRepository->addVehicleToFleet(
                $registerVehicleCommand->getVehicleRegistrationNumber(),
                $registerVehicleCommand->getUserId()
            );


        } catch (Exception $e) {
            $this->getCommandResponse()->setError($e->getMessage());
        }
    }

}