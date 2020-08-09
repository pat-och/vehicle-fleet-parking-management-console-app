<?php

declare(strict_types=1);


namespace App\command\fleet\app;


class RegisterVehicleCommand
{

    private string $userId;
    private string $vehicleRegistrationNumber;

    public function __construct(string $userId, string $vehicleRegistrationNumber)
    {
        $this->userId = $userId;
        $this->vehicleRegistrationNumber = $vehicleRegistrationNumber;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getVehicleRegistrationNumber(): string
    {
        return $this->vehicleRegistrationNumber;
    }
}