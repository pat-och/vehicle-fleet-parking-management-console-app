<?php

declare(strict_types=1);


namespace Tests\acceptance\command\fleet;

use PHPUnit\Framework\TestCase;
use App\command\shared\app\CommandResponse;
use App\command\fleet\app\CreateFleetCommandHandler;
use App\command\fleet\infra\FleetRepositoryInterface;

class CreateFleetCommandHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function createFleetForFooUserSuccessfully()
    {
//        $fooUserId = $this->fooUserExists();
//
//        $fleetRepository = new InMemoryFleetRepository();
//        $this->createFleet($fooUserId, $fleetRepository);
//
//        $this->assertNotNull($fleetRepository->getFleet($fooUserId));
    }

    private function fooUserExists()
    {
        return 'foo';
    }

    private function createFleet(string $fooUserId, FleetRepositoryInterface $fleetRepository)
    {
        $commandResponse = new CommandResponse();
        $createFleetCommandHandler = new CreateFleetCommandHandler($fleetRepository, $commandResponse);
        $createFleetCommandHandler->handle($fooUserId);
    }
}
