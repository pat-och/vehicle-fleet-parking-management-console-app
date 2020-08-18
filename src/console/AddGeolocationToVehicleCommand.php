<?php

namespace App\console;

use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AddGeolocationToVehicleCommand extends Command
{
    protected static $defaultName = 'fleet:geolocate-for-inextenso-demo-only';
    private VehicleRepository $vehicleRepository;
    private EntityManagerInterface $em;

    public function __construct(VehicleRepository $vehicleRepository,
                                EntityManagerInterface $em,
                                string $name = null)
    {
        $this->vehicleRepository = $vehicleRepository;
        parent::__construct($name);
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription(
                'this command adds a geolocation to all vehicles for the needs of the inextenso de' . 'mo.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->updateVehicles();

        $io->success('all vehicles in DB have now (123, 456) as geopoint.');

        return 0;
    }

    private function updateVehicles()
    {
        foreach ($this->vehicleRepository->findAll() as $vehicle) {
            $vehicle->setLatitude('123');
            $vehicle->setLongitude('456');
            $this->em->persist($vehicle);
        }
        $this->em->flush();
    }
}
