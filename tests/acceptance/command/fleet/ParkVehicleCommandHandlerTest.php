<?php

declare(strict_types=1);


namespace Tests\acceptance\command\fleet;

use App\command\fleet\app\ParkVehicleCommand;
use App\command\fleet\app\ParkVehicleCommandHandler;
use App\command\fleet\app\ParkVehicleCommandResponse;
use App\command\fleet\domain\Geolocation;
use App\command\fleet\infra\InMemoryFleetRepository;
use App\command\shared\app\CommandResponse;
use PHPUnit\Framework\TestCase;

class ParkVehicleCommandHandlerTest extends TestCase
{

    /**
     * @test
     */
    public function successfullyParkFooVehicleAtBarLocation()
    {
        /**
         * arrange
         */

        // given i
        $myUserId = 'abc';

        // given i have a fleet
        $fleetRepository = new InMemoryFleetRepository();
        $fleetRepository->addFleet($myUserId);

        // given a registered vehicle
        $fooVehicleRegistrationNumber = 'foo';
        $fleetRepository->addVehicleToFleet($fooVehicleRegistrationNumber, $myUserId);

        // given location
        $barLocation = new Geolocation('43.300000', '5.400000');

        /**
         * act
         */
        $commandResponse = new CommandResponse();
        $parkVehicle = new ParkVehicleCommandHandler($fleetRepository, $commandResponse);
        $parkVehicle->handle(
            new ParkVehicleCommand($myUserId, $fooVehicleRegistrationNumber, $barLocation)
        );

        $this->assertEquals(
            $barLocation,
            $fleetRepository->getfooVehicleGeolocation($fooVehicleRegistrationNumber, $myUserId, $barLocation)
        );
    }

    /**
     * @test
     */
    public function cantLocalizeMyVehicleToTheSameLocationTwoTimesInARow()
    {
        /**
         * arrange
         */

        // given i
        $myUserId = 'abc';

        // given i have a fleet
        $fleetRepository = new InMemoryFleetRepository();
        $fleetRepository->addFleet($myUserId);

        // given location
        $barLocation = new Geolocation('43.300000', '5.400000');

        // given a registered vehicle
        $fooVehicleRegistrationNumber = 'foo';
        $fleetRepository->addVehicleToFleet($fooVehicleRegistrationNumber, $myUserId, $barLocation);

        /**
         * act
         */
        $commandResponse = new CommandResponse();
        $parkVehicleCommandHandler = new ParkVehicleCommandHandler($fleetRepository, $commandResponse);

        $parkVehicleCommandHandler->handle(
            new ParkVehicleCommand($myUserId, $fooVehicleRegistrationNumber, $barLocation)
        );

        /**
         * assert
         */
        $this->assertEquals(
            'This vehicle is already parked at this location.',
            $commandResponse->getError()
        );
    }
}
