<?php

namespace App\console;

use App\command\fleet\app\CreateFleetCommand;
use App\command\fleet\app\CreateFleetCommandHandler;
use App\command\fleet\app\RegisterVehicleCommand;
use App\command\fleet\app\RegisterVehicleCommandHandler;
use App\command\fleet\infra\FleetRepositoryInterface;
use App\command\fleet\infra\InMemoryFleetRepository;
use App\command\shared\app\CommandResponse;
use App\query\app\FleetQueryHandlerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RegisterVehicleConsoleCommand extends Command
{
    protected static $defaultName = 'fleet:register-vehicle';

    protected function configure()
    {
        $this
            ->setDescription('Register a vehicle into a fleet.')
            ->addArgument('fleetId', InputArgument::REQUIRED, 'fleet ID')
            ->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'vehicle plate number')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $fleetId = $input->getArgument('fleetId');
        $vehiclePlateNumber = $input->getArgument('vehiclePlateNumber');

        if (!isset($fleetId)) {
            $io->error('invalid fleet ID');
            return 0;
        }
        if (!isset($vehiclePlateNumber)) {
            $io->error('invalid vehicle plate number');
            return 0;
        }

        $fleetRepository = new InMemoryFleetRepository();

        $fleetRepository->addFleet($fleetId);
//        $fleetRepository->addVehicleToFleet($vehiclePlateNumber, $fleetId);

        $commandResponse = new CommandResponse();

        $registerVehicleCommandHandler = new RegisterVehicleCommandHandler($fleetRepository, $commandResponse);
        $registerVehicleCommandHandler(
            new RegisterVehicleCommand($fleetId, $vehiclePlateNumber)
        );

        if ($commandResponse->hasError()) {
            $io->error($commandResponse->getError());
            return 0;
        }

        $io->success('Vehicle successfully registered into fleet');
        return 0;
    }
}