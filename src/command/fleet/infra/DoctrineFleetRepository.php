<?php

declare(strict_types=1);


namespace App\command\fleet\infra;


use App\command\fleet\domain\Fleet;
use App\command\fleet\domain\Geolocation;
use App\command\fleet\domain\Vehicle;
use App\Entity\Vehicle as DoctrineVehicle;
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

        $vehicles = array();
        foreach ($doctrineFleet->getVehicles()->toArray() as $vehicle) {

            $geolocation = null;
            if (null !== $vehicle->getLatitude() && null !== $vehicle->getLongitude()) {
                $geolocation = new Geolocation($vehicle->getLatitude(), $vehicle->getlongitude());
            }

            $vehicles[$vehicle->getRegistrationNumber()] = new Vehicle(
                $vehicle->getRegistrationNumber(),
                $geolocation
            );
        }

        return new Fleet($userId, $vehicles);
    }

    public function addVehicleToFleet(string $vehicleRegistrationNumber,
                                      string $userId,
                                      Geolocation $geolocation = null): void
    {
        $userFleet = $this->fleetRepository->findOneBy(array('user_id' => $userId));

        foreach ( $userFleet->getVehicles() as $vehicle) {
            if ($vehicleRegistrationNumber === $vehicle->getRegistrationNumber()) {
                return;
            }
        }

        $vehicle = new DoctrineVehicle();
        $vehicle->setUuid($vehicleRegistrationNumber);
        $vehicle->setRegistrationNumber($vehicleRegistrationNumber);

        $userFleet->addVehicle($vehicle);

        $this->entityManager->persist($userFleet);
        $this->entityManager->flush();
    }


    public function userAlreadyHasFleet(string $userId): bool
    {
        $fleet = $this->getFleet($userId);
        return isset($fleet);
    }
}