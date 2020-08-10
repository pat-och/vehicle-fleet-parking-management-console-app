<?php

declare(strict_types=1);


namespace Tests\acceptance\command\fleet;

use App\command\fleet\app\CreateFleetCommand;
use App\command\fleet\app\CreateFleetCommandHandler;
use PHPUnit\Framework\TestCase;
use App\command\shared\app\CommandResponse;
use App\command\fleet\infra\InMemoryFleetRepository;
use App\command\fleet\infra\FleetRepositoryInterface;

class CreateFleetCommandHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function createFleetForFooUserSuccessfully()
    {
        $fooUserId = $this->fooUserExists();

        $fleetRepository = new InMemoryFleetRepository();
        $this->createFleet($fooUserId, $fleetRepository);

        $this->assertNotNull($fleetRepository->getFleet($fooUserId));
    }

    /**
     * @test
     */
    public function cantCreateTwiceSameFleetForFooUser()
    {
        $fooUserId = $this->fooUserExists();

        $fleetRepository = new InMemoryFleetRepository();

        $this->assertTrue(
            $fleetRepository->hasOnlyOneFooUserFleet($fooUserId)
        );
    }

    private function fooUserExists()
    {
        return 'foo';
    }

    private function createFleet(string $userId, FleetRepositoryInterface $fleetRepository)
    {
        $createFleetCommand = new CreateFleetCommand($userId);
        $commandResponse = new CommandResponse();

        $createFleetCommandHandler = new CreateFleetCommandHandler($fleetRepository, $commandResponse);
        $createFleetCommandHandler->handle($createFleetCommand->getUserId());
    }
}
