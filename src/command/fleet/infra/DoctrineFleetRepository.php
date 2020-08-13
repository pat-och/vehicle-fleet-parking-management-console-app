<?php

declare(strict_types=1);


namespace App\command\fleet\infra;


use App\command\fleet\domain\Fleet;
use App\command\fleet\domain\Geolocation;
use App\Repository\FleetRepository;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineFleetRepository implements FleetRepositoryInterface
{

    private FleetRepository $fleetRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, FleetRepository $fleetRepository)
    {
        $this->fleetRepository = $fleetRepository;
        $this->entityManager = $entityManager;
    }

    public function addFleet(string $userId): void
    {
        // TODO: Implement addFleet() method.
    }

    public function getFleet(string $userId): ?Fleet
    {
        // TODO: Implement getFleet() method.
    }

    public function addVehicleToFleet(string $vehicleRegistrationNumber, string $userId, Geolocation $geolocation = null): void
    {
        // TODO: Implement addVehicleToFleet() method.
    }

    public function all(): array
    {
        // TODO: Implement all() method.
    }
}