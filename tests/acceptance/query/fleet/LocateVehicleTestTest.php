<?php

declare(strict_types=1);


namespace Tests\acceptance\query\fleet;

use App\query\app\GeolocationOfVehicle;
use App\query\infra\InMemoryFleetQueryHandler;
use PHPUnit\Framework\TestCase;

class LocateVehicleTestTest extends TestCase
{
    /**
     * @test
     */
    public function iCanLocateFooVehicleInBarFleet()
    {
        $barFleetId = 'bar';
        $fooVehicleRegistrationNumber = 'foo';

        $FleetQueryHandler = new InMemoryFleetQueryHandler();

        $this->assertEquals(
            new GeolocationOfVehicle('foo', '999', '999'),
            $FleetQueryHandler->locateVehicle($fooVehicleRegistrationNumber, $barFleetId)
        );

    }
}
