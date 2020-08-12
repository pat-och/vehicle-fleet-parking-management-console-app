<?php

namespace App\console;

use App\query\app\FleetQueryHandlerInterface;
use App\query\infra\InMemoryFleetQueryHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class LocalizeVehicleCommand extends Command
{
    protected static $defaultName = 'localize-vehicle';
    private FleetQueryHandlerInterface $fleetQueryHandler;

    public function __construct(FleetQueryHandlerInterface $fleetQueryHandler, string $name = null)
    {
//        $this->fleetQueryHandler = $fleetQueryHandler;
        $this->fleetQueryHandler = new InMemoryFleetQueryHandler();
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('localize vehicle of given fleet')
            ->addArgument('fleetId', InputArgument::REQUIRED, 'fleet id')
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

        $locateVehicle = $this->fleetQueryHandler->locateVehicle($vehiclePlateNumber, $fleetId);

        if (!isset($locateVehicle)) {
            $io->error('impossible to locate this vehicle.');
        }

        $io->success(
            sprintf(
                'Vehicle %s located at geopoint %s, %s',
                $locateVehicle->vehicleId,
                $locateVehicle->latitude,
                $locateVehicle->longitude
            )
        );

        return 0;
    }
}
