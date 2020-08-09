<?php

declare(strict_types=1);

namespace Tests\command\fleet;

use App\command\fleet\app\RegisterVehicleCommand;
use App\command\fleet\app\RegisterVehicleCommandHandler;
use App\command\fleet\app\RegisterVehicleCommandResponse;
use App\command\fleet\infra\InMemoryFleetRepository;
use PHPUnit\Framework\TestCase;

class RegisterVehicleCommandHandlerTest extends TestCase
{
    private string $myUserId;
    private InMemoryFleetRepository $fleetRepository;
    private string $nonRegisteredFooVehicleRegistrationNumber;
    private string $registeredFooVehicleRegistrationNumber;
    private string $anotherUserId;

    protected function setUp(): void
    {
        $this->fleetRepository = new InMemoryFleetRepository();
    }

    /**
     * @test
     */
    public function iCanRegisterFooVehicleInToMyFleet()
    {
        $this->givenImRegisteredUser();
        $this->givenIHaveMyFleet();
        $this->givenNonRegisteredFooVehicleRegistrationNumber();

        $registerVehicle = new RegisterVehicleCommandHandler(
            $this->fleetRepository,
            new RegisterVehicleCommandResponse()
        );

        $registerVehicle(
            new RegisterVehicleCommand($this->myUserId, $this->nonRegisteredFooVehicleRegistrationNumber)
        );

        $this->assertTrue(
            $this->fleetRepository->hasFooVehicleIntoFleet($this->nonRegisteredFooVehicleRegistrationNumber,
                $this->myUserId)
        );
    }

    /**
     * @test
     */
    public function iCantRegisterTwiceFooVehicleInToMyFleet()
    {
        $this->givenImRegisteredUser();
        $this->givenIHaveMyFleet();
        $this->givenRegisteredFooVehicleRegistrationNumber();

        $registerVehicleCommandResponse = new RegisterVehicleCommandResponse();
        $registerVehicle = new RegisterVehicleCommandHandler($this->fleetRepository, $registerVehicleCommandResponse);
        $registerVehicle(
            new RegisterVehicleCommand($this->myUserId, $this->registeredFooVehicleRegistrationNumber)
        );

        $this->assertEquals(
            'this vehicle has already been registered into your fleet',
            $registerVehicleCommandResponse->getError()
        );
    }

    /**
     * @test
     */
    public function sameVehicleCanBelongToMoreThanOneFleet()
    {
        $this->givenImRegisteredUser();
        $this->givenIHaveMyFleet();
        $this->givenRegisteredFooVehicleIntoAnotherUserFleet();


        $registerVehicle = new RegisterVehicleCommandHandler(
            $this->fleetRepository,
            new RegisterVehicleCommandResponse()
        );

        $registerVehicle(
            new RegisterVehicleCommand($this->myUserId, $this->registeredFooVehicleRegistrationNumber)
        );

        $this->assertTrue(
            $this->fleetRepository->hasFooVehicleIntoFleet(
                $this->registeredFooVehicleRegistrationNumber,
                $this->myUserId
            )
        );
    }

    private function givenImRegisteredUser()
    {
        $this->myUserId = 'abc';
    }
    private function givenIHaveMyFleet()
    {
        $this->fleetRepository = new InMemoryFleetRepository();
        $this->fleetRepository->addFleet($this->myUserId);
    }

    private function givenNonRegisteredFooVehicleRegistrationNumber()
    {
        $this->nonRegisteredFooVehicleRegistrationNumber = 'foo';
    }

    private function givenRegisteredFooVehicleRegistrationNumber()
    {
        $this->registeredFooVehicleRegistrationNumber = 'foo';
        $this->fleetRepository->addVehicleToFleet($this->registeredFooVehicleRegistrationNumber, $this->myUserId);
    }

    private function givenTheFleetOfAnotherUser()
    {
        $this->anotherUserId = 'def';
        $this->fleetRepository->addFleet($this->anotherUserId);
    }

    private function givenRegisteredFooVehicleIntoAnotherUserFleet()
    {
        $this->givenTheFleetOfAnotherUser();

        $this->registeredFooVehicleRegistrationNumber = 'foo';
        $this->anotherUserId = 'def';
        $this->fleetRepository->addVehicleToFleet($this->registeredFooVehicleRegistrationNumber, $this->anotherUserId);
    }

}
