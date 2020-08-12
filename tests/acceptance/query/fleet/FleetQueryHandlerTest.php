<?php

declare(strict_types=1);


namespace Tests\acceptance\query;

use App\query\app\FleetQueryHandlerInterface;
use App\query\infra\InMemoryFleetQueryHandler;
use PHPUnit\Framework\TestCase;

class FleetQueryHandlerTest extends TestCase
{

    /**
     * @test
     */
    public function getAllFleetsSuccessfully()
    {
        $fleetQueryHandler = new InMemoryFleetQueryHandler();
        $this->thoseFleetsExists($this->thoseRegisteredUsersExists(), $fleetQueryHandler);

        $this->assertEquals(
            array(
                'A0EEBC99-9C0B-4EF8-BB6D-6BB9BD380A11' => array(),
                '12' => array(),
                '007' => array()
            ),
            $fleetQueryHandler->getAll()
        );
    }

    private function thoseFleetsExists(array $users, FleetQueryHandlerInterface $fleetQueryHandler): void
    {
        $fleetQueryHandler->createFleets($users);
    }

    private function thoseRegisteredUsersExists(): array
    {
        return array(
            'A0EEBC99-9C0B-4EF8-BB6D-6BB9BD380A11',
            '12',
            '007'
        );
    }
}
