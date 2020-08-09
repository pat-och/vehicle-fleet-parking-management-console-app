<?php

declare(strict_types=1);


namespace App\command\fleet\app;


class ParkVehicleCommandResponse
{
    private string $error;

    public function setError(string $errorMessage): void
    {
        $this->error = $errorMessage;
    }

    public function getError(): ?string
    {
        return $this->error;
    }
}