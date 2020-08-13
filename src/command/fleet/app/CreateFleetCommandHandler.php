<?php

declare(strict_types=1);


namespace App\command\fleet\app;


use App\command\fleet\infra\FleetRepositoryInterface;
use App\command\shared\app\CommandHandler;
use App\command\shared\app\CommandResponse;

class CreateFleetCommandHandler extends CommandHandler
{

    private FleetRepositoryInterface $fleetRepository;

    public function __construct(FleetRepositoryInterface $fleetRepository, CommandResponse $commandResponse)
    {
        $this->fleetRepository = $fleetRepository;
        parent::__construct($commandResponse);
    }

    public function handle(CreateFleetCommand $createFleetCommand): void
    {
        if ($this->fleetRepository->userAlreadyHasFleet($createFleetCommand->getUserId())) {
            $this->getCommandResponse()->setError('this fleet already exists');
            return;
        }

        $this->fleetRepository->addFleet($createFleetCommand->getUserId());
    }
}