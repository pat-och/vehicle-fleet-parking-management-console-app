<?php

declare(strict_types=1);


namespace App\query\infra;


use App\query\app\FleetQueryHandlerInterface;

class InMemoryFleetQueryHandler implements FleetQueryHandlerInterface
{

    private array $fleets = array();

    public function getAll(): array
    {
        return $this->fleets;
    }

    public function createFleets(array $fleets): void
    {
        foreach ($fleets as $fleet) {
            $this->addFleet($fleet);
        }
    }

    private function addFleet(string $fleetId): void
    {
        if (!array_key_exists($fleetId, $this->fleets)) {
            $this->fleets[$fleetId] = array();
        }
    }
}