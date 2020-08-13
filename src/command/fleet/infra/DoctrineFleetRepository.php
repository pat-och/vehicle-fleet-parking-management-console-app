<?php

declare(strict_types=1);


namespace App\command\fleet\infra;


use App\command\fleet\domain\Fleet;
use App\command\fleet\domain\Geolocation;
use App\Entity\Vehicle;
use App\Repository\FleetRepository;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Fleet as DoctrineFleet;

class DoctrineFleetRepository implements FleetRepositoryInterface
{

    private array $fleets = array();

    private FleetRepository $fleetRepository;
    private EntityManagerInterface $entityManager;
    private Connection $connection;

    public function __construct(EntityManagerInterface $entityManager,
                                FleetRepository $fleetRepository,
                                Connection $connection)
    {
        $this->fleetRepository = $fleetRepository;
        $this->entityManager = $entityManager;
        $this->connection = $connection;
    }

    public function addFleet(string $userId): void
    {
        $doctrineFleet = new DoctrineFleet();

        $doctrineFleet->setUuid($userId);
        $doctrineFleet->setUserId($userId);

        $this->entityManager->persist($doctrineFleet);
        $this->entityManager->flush();
    }

    public function getFleet(string $userId): ?Fleet
    {
        $doctrineFleet = $this->fleetRepository->findOneBy(array('user_id' => $userId));

        if (!isset($doctrineFleet)) {
            return null;
        }

        return new Fleet($userId);
    }

    public function addVehicleToFleet(string $vehicleRegistrationNumber,
                                      string $userId,
                                      Geolocation $geolocation = null): void
    {
        print_r('wtffffffffffffffffffffffffffffffff');

        $doctrineFleet = $this->fleetRepository->findOneBy(array('user_id' => $userId));

        $vehicle = new Vehicle();
        $vehicle->setUuid($vehicleRegistrationNumber);
        $vehicle->setRegistrationNumber($vehicleRegistrationNumber);

        $doctrineFleet->addVehicle($vehicle);

        $this->entityManager->persist($doctrineFleet);
        $this->entityManager->flush();
    }


    public function userAlreadyHasFleet(string $userId): bool
    {
        $fleet = $this->getFleet($userId);
        return isset($fleet);
    }
}