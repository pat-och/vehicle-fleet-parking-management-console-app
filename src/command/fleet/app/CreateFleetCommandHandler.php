<?php

declare(strict_types=1);


namespace App\command\fleet\app;


use App\command\fleet\infra\FleetRepositoryInterface;
use App\command\shared\app\CommandResponse;

class CreateFleetCommandHandler
{

    private FleetRepositoryInterface $fleetRepository;
    private CommandResponse $commandResponse;

    public function __construct(FleetRepositoryInterface $fleetRepository, CommandResponse $commandResponse)
    {
        $this->fleetRepository = $fleetRepository;
        $this->commandResponse = $commandResponse;
    }

    public function handle(string $userId): void
    {
        if (!array_key_exists($userId, $this->fleetRepository->all())) {
            $this->fleetRepository->addFleet($userId);
        }
    }
}