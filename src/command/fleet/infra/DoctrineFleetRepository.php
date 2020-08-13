<?php

declare(strict_types=1);


namespace App\command\fleet\infra;


use App\command\fleet\domain\Fleet;
use App\command\fleet\domain\Geolocation;
use App\Repository\FleetRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Fleet as DoctrineFleet;

class DoctrineFleetRepository implements FleetRepositoryInterface
{

    private array $fleets = array();

    private FleetRepository $fleetRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, FleetRepository $fleetRepository)
    {
        $this->fleetRepository = $fleetRepository;
        $this->entityManager = $entityManager;
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
        // TODO: Implement getFleet() method.
    }

    public function addVehicleToFleet(string $vehicleRegistrationNumber, string $userId, Geolocation $geolocation = null): void
    {
        // TODO: Implement addVehicleToFleet() method.
    }


    public function userAlreadyHasFleet(string $userId): bool
    {
        $fleet = $this->fleetRepository->findOneBy(array('user_id' => $userId));
        return isset($fleet);
    }
}